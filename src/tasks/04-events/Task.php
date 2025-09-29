<?php

class OrderService
{
	public function complete(Order $order): void
	{
		$orderId = $order->getId();
		$userId = $order->getUser()->getUserId();

		echo "Order #{$orderId} completed" . PHP_EOL;

		(new Notifier())->send($order->getUser()->getPhone(), 'Order is completed');
		(new Logger())->log("Order ({$orderId}) from user ({$userId}) completed at " . date('Y-m-d H:i:s'));
	}
}


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


final class Notifier
{
	public function send(string $to, string $msg): void
	{
		echo "[SMS] $msg" . PHP_EOL;
	}
}

final class Logger
{
	public function log(string $msg): void
	{
		echo "[LOG] $msg" . PHP_EOL;
	}
}


(new OrderService())->complete(
	new Order(
		1121,
		new User('bob@example.com', '+1 123 456 7890'),
		new Amount(110, 'usd'),
		[]
	)
);
