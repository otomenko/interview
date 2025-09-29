<?php

readonly class InvoiceService
{
	public function __construct(private Logger $logger)
	{
	}

	/**
	 * TODO: 1. Please refactor the handling of paymentGateway.
	 * TODO: 2. Refactor the notification sending so the channels can be controlled externally. The system should be configurable to send only email, only SMS, or both.
	 */
	public function charge(User $user, Order $order, string $paymentGateway): void
	{
		try {
			$amount = $order->getAmount();
			if ($paymentGateway === 'stripe') {
				$userStripe = new UserStripe($user->getUserId());
				(new Stripe())->charge($amount->amount, $amount->currency, $userStripe->getToken());
			} elseif ($paymentGateway === 'worldpay') {
				$userWorldPay = new UserWorldPay($user->getUserId());
				(new Worldpay())->charge($amount->toFloat(), $amount->currency, $userWorldPay->getCardNumber(), $userWorldPay->getCvv());
			} elseif ($paymentGateway === 'adyen') {
				$userAdyen = new UserAdyen($user->getUserId());
				(new Adyen())->charge($amount->amount, $amount->currency, $userAdyen->getWalletId());
			}

			$this->successNotify($user, $order->getId());
		} catch (\Throwable $t) {
			$this->logger->log($t->getMessage());
			$this->failedNotify($user, $order->getId());
		}
	}

	private function successNotify(User $user, int $orderId): void
	{
		(new EmailChannel())->sendemail(
			$user->getEmail(),
			"Payment for order #{$orderId} has been completed successfully. Thank you for using our service!",
			'Super comp Inc. Payment was successful.'
		);
		(new SmsChannel())->sendSms(
			$user->getPhone(),
			"Payment for order #{$orderId} has been completed successfully."
		);
	}

	private function failedNotify(User $user, int $orderId): void
	{
		(new EmailChannel())->sendemail(
			$user->getEmail(),
			"Unfortunately, the payment for order #{$orderId} could not be processed. Please try again or use a different payment method.",
			'Super comp Inc. Payment failed.'
		);
		(new SmsChannel())->sendSms(
			$user->getPhone(),
			"Unfortunately, the payment for order #{$orderId} could not be processed."
		);
	}
}

$paymentGateways = ['stripe', 'worldpay', 'adyen'];

$user = new User('bob@example.com', '+1 123 456 7890');
$order = new Order(1, $user, new Amount(110, 'usd'), []);

(new InvoiceService(new Logger()))->charge($user, $order, $paymentGateways[array_rand($paymentGateways)]);


class User
{
	private readonly string $uuid;

	public function __construct(private string $email, private string $phone)
	{
		$this->uuid = uniqid();
	}

	public function getUserId(): string
	{
		return $this->uuid;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPhone(): string
	{
		return $this->phone;
	}
}

final class Order
{
	public function __construct(private int $id, private User $user, private Amount $amount, private array $items)
	{
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getUser(): User
	{
		return $this->user;
	}

	public function getAmount(): Amount
	{
		return $this->amount;
	}

	public function getItems(): array
	{
		return $this->items;
	}
}

readonly class Amount
{
	public function __construct(public int $amount, public string $currency)
	{
	}

	public function toFloat(int $precision = 2): float
	{
		return round(($this->amount / 100), $precision);
	}
}


/** Mocks for payment SDKs */
class Stripe
{
	public function charge(int $amount, string $currency, string $token): void
	{
	}
}

readonly class UserStripe
{
	public function __construct(private string $userId)
	{
	}

	public function getToken(): string
	{
		return md5($this->userId);
	}
}

class Worldpay
{
	public function charge(float $amount, string $currency, string $cardNumber, int $cvv): void
	{
	}
}

readonly class UserWorldPay
{
	public function __construct(private string $userId)
	{
	}

	public function getCardNumber(): string
	{
		return '4111 1111 1111 1111';
	}

	public function getCvv(): string
	{
		return '123';
	}
}

class Adyen
{
	public function charge(float $amount, string $currency, string $walletId): void
	{
	}
}

readonly class UserAdyen
{
	public function __construct(private string $userId)
	{
	}

	public function getWalletId(): string
	{
		return sha1($this->userId);
	}
}


/** Mocks for notifier SDKs */
final class SmsChannel
{
	public function sendSms(string $phoneNumber, string $message): void
	{
		echo 'Sms: ' . $message . PHP_EOL;
	}
}

final class EmailChannel
{
	public function sendEmail(string $email, string $body, string $subject): void
	{
		echo 'Email: ' . $body . PHP_EOL;
	}
}

final class Logger
{
	public function log(string $message): void
	{
	}
}
