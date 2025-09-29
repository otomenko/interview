build:
	docker build -t interview-php ./docker/images/php

run-t1:
	docker run --rm -it -v "$$(pwd)/src":/app -w /app interview-php php tasks/01-arrays/run.php

run-t2:
	docker run --rm -it -v "$$(pwd)/src":/app -w /app interview-php php tasks/02-order/run.php

run-t3:
	docker run --rm -it -v "$$(pwd)/src":/app -w /app interview-php php tasks/03-invoice/run.php

run-t4:
	docker run --rm -it -v "$$(pwd)/src":/app -w /app interview-php php tasks/03-events/run.php
