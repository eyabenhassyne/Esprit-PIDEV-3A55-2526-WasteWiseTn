<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeWithdrawService
{
    private const STRIPE_BASE_URL = 'https://api.stripe.com/v1';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly EntityManagerInterface $entityManager,
        private readonly string $secretKey,
        private readonly string $payoutCurrency,
        private readonly string $appBaseUrl,
        private readonly string $connectedAccountCountry
    ) {
    }

    public function isEnabled(): bool
    {
        return '' !== trim($this->secretKey);
    }

    public function getPayoutCurrency(): string
    {
        return strtoupper($this->payoutCurrency);
    }

    public function isConnected(User $user): bool
    {
        return null !== $user->getStripeConnectAccountId() && '' !== trim((string) $user->getStripeConnectAccountId());
    }

    public function createOnboardingLink(User $user): array
    {
        if (!$this->isEnabled()) {
            return ['success' => false, 'error' => 'Stripe n est pas configure (STRIPE_SECRET_KEY manquante).'];
        }

        $accountResult = $this->ensureConnectedAccount($user);
        if (!($accountResult['success'] ?? false)) {
            return $accountResult;
        }

        $accountId = (string) $accountResult['account_id'];
        $refreshUrl = rtrim($this->appBaseUrl, '/').'/citoyen/withdraw?stripe=retry';
        $returnUrl = rtrim($this->appBaseUrl, '/').'/citoyen/withdraw?stripe=done';

        $response = $this->stripeRequest('POST', '/account_links', [
            'account' => $accountId,
            'refresh_url' => $refreshUrl,
            'return_url' => $returnUrl,
            'type' => 'account_onboarding',
        ]);

        if (!($response['success'] ?? false)) {
            return $response;
        }

        $url = (string) (($response['data']['url'] ?? ''));
        if ('' === $url) {
            return ['success' => false, 'error' => 'Stripe a retourne un lien onboarding invalide.'];
        }

        return [
            'success' => true,
            'url' => $url,
            'account_id' => $accountId,
        ];
    }

    public function createPayout(User $user, int $amountMinor, string $description): array
    {
        if (!$this->isEnabled()) {
            return ['success' => false, 'error' => 'Stripe n est pas configure (STRIPE_SECRET_KEY manquante).'];
        }

        if ($amountMinor <= 0) {
            return ['success' => false, 'error' => 'Montant de retrait invalide.'];
        }

        $accountResult = $this->ensureConnectedAccount($user);
        if (!($accountResult['success'] ?? false)) {
            return $accountResult;
        }

        $accountId = (string) $accountResult['account_id'];

        $response = $this->stripeRequest(
            'POST',
            '/payouts',
            [
                'amount' => $amountMinor,
                'currency' => strtolower($this->payoutCurrency),
                'description' => $description,
            ],
            $accountId
        );

        if (!($response['success'] ?? false)) {
            return $response;
        }

        $payoutId = (string) (($response['data']['id'] ?? ''));
        if ('' === $payoutId) {
            return ['success' => false, 'error' => 'Stripe a retourne une reponse payout invalide.'];
        }

        return [
            'success' => true,
            'payout_id' => $payoutId,
            'status' => (string) (($response['data']['status'] ?? 'unknown')),
            'account_id' => $accountId,
        ];
    }

    private function ensureConnectedAccount(User $user): array
    {
        if ($this->isConnected($user)) {
            return [
                'success' => true,
                'account_id' => (string) $user->getStripeConnectAccountId(),
            ];
        }

        $response = $this->stripeRequest('POST', '/accounts', [
            'type' => 'express',
            'country' => strtoupper($this->connectedAccountCountry),
            'email' => (string) $user->getEmail(),
            'capabilities' => [
                'transfers' => ['requested' => 'true'],
            ],
            'business_type' => 'individual',
            'metadata' => [
                'wastewise_user_id' => (string) ($user->getId() ?? ''),
                'wastewise_email' => (string) $user->getEmail(),
            ],
        ]);

        if (!($response['success'] ?? false)) {
            return $response;
        }

        $accountId = (string) (($response['data']['id'] ?? ''));
        if ('' === $accountId) {
            return ['success' => false, 'error' => 'Creation compte Stripe invalide.'];
        }

        $user->setStripeConnectAccountId($accountId);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            'success' => true,
            'account_id' => $accountId,
        ];
    }

    private function stripeRequest(string $method, string $path, array $data = [], ?string $stripeAccount = null): array
    {
        try {
            $headers = [
                'Authorization' => sprintf('Bearer %s', $this->secretKey),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];

            if (null !== $stripeAccount) {
                $headers['Stripe-Account'] = $stripeAccount;
            }

            $response = $this->httpClient->request($method, self::STRIPE_BASE_URL.$path, [
                'headers' => $headers,
                'body' => http_build_query($data),
                'timeout' => 30,
            ]);

            $statusCode = $response->getStatusCode();
            $payload = $response->toArray(false);

            if ($statusCode >= 400) {
                $errorMessage = 'Erreur Stripe.';
                if (is_array($payload) && isset($payload['error']['message'])) {
                    $errorMessage = (string) $payload['error']['message'];
                }

                if (str_contains(strtolower($errorMessage), 'signed up for connect')) {
                    return [
                        'success' => false,
                        'error' => 'Stripe Connect n est pas active sur ce compte. Activez Connect dans le dashboard Stripe, puis reessayez.',
                    ];
                }

                return [
                    'success' => false,
                    'error' => sprintf('Stripe %d: %s', $statusCode, $errorMessage),
                ];
            }

            return [
                'success' => true,
                'data' => is_array($payload) ? $payload : [],
            ];
        } catch (\Throwable $exception) {
            return [
                'success' => false,
                'error' => sprintf('Erreur reseau Stripe: %s', $exception->getMessage()),
            ];
        }
    }
}
