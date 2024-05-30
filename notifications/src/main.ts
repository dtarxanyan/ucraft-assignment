import {NestFactory} from '@nestjs/core';
import {RabbitMQService} from './rabbitmq.service';
import {AppModule} from './app.module';
import "reflect-metadata"

async function bootstrap() {
    const app = await NestFactory.create(AppModule);
    const rabbitMQService = app.get(RabbitMQService);

    // Start the RabbitMQ consumer
    rabbitMQService.startConsumer();

    // await app.listen(3000);
}

bootstrap();
