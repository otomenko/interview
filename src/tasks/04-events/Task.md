# Event Bus

**Файл для змін:** `Task.php`  
**Запуск:** `make run-t4`

## Завдання 1
Перейти з монолітної на модель з шиною подій (EventBus).
- Реалізувати простий `EventBus`, який дозволяє:
  - `subscribe(string $eventName, EventHandler $handler)`
  - `publish(Event $event)`
- Винести відправку sms/log в обробники події `OrderCompletedEvent`.
- `OrderService` має лише публікувати подію `OrderCompletedEvent`.
