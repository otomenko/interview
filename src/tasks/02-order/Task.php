<?php

class OrderService
{
	public function process(array $order)
	{
		$tax = 0.5;
		$discount = 0;

		if (!isset($order['items']) || !is_array($order['items']) || count($order['items']) === 0) {
			throw new \RuntimeException("no items");
		}
		if (!isset($order['user_id'])) {
			throw new \RuntimeException("no user");
		}

		$sum = 0;
		foreach ($order['items'] as $i => $item) {
			if (!isset($item['price']) || !isset($item['qty'])) {
				throw new \RuntimeException("bad item at $i");
			}
			$sum += $item['price'] * $item['qty'];

			if (isset($order['coupon']) && $order['coupon'] === 'batman3') {
				$discount += ($item['price'] * $item['qty']) * 0.10;
			} elseif (isset($order['coupon']) && $order['coupon'] === 'rabbit033') {
				$discount += ($item['price'] * $item['qty']) * 0.20;
			}
		}

		$subtotal = $sum - $discount;
		if ($subtotal < 0) {
			$subtotal = 0;
		}

		if (isset($order['country']) && $order['country'] === 'CA') {
			$tax = 0.1;
		} elseif (isset($order['country']) && $order['country'] === 'US') {
			$tax = 0.2;
		}

		$taxAmount = $subtotal * $tax;
		$total = $subtotal - $taxAmount;
		if ($total < 0) {
			$total = 0;
		}

		$orderRepository = new OrderRepository();
		$orderId = (int) $orderRepository->insert([
			'user_id' => $order['user_id'],
			'total' => $total,
			'taxAmount' => $taxAmount,
			'discount' => $discount,
			'createdat' => time(),
		]);

		return [
			'order_id' => $orderId,
			'total' => $total,
			'tax' => $taxAmount,
			'discount' => $discount,
		];
	}
}

final class OrderRepository
{
	private $data = [];

	public function insert(array $payload): int
	{
		$this->data[] = $payload;

		return array_key_last($this->data);
	}
}


$service = new OrderService();

var_dump($service->process([
	'user_id' => 234,
	'country' => 'CA',
	'coupon' => 'batman3',
	'items' => [
		[
			'name' => 'table',
			'price' => 5000,
			'qty' => 2,
		],
		[
			'name' => 'bed',
			'price' => 10000,
			'qty' => 1,
		],
	],
]));
