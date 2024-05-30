import {Injectable} from '@nestjs/common';
import * as amqp from 'amqplib';
import {NotificationService} from './notification.service';
import {MessageFactory} from "./message.factory";

@Injectable()
export class RabbitMQService {
    constructor(
        private readonly notificationService: NotificationService,
        private readonly messageFactory: MessageFactory
    ) {
    }

    async createConnection(): Promise<any> {
        const host = process.env.RABBITMQ_HOST
        const port = process.env.RABBITMQ_PORT;
        const user = process.env.RABBITMQ_USER;
        const password = process.env.RABBITMQ_PASSWORD;

        return amqp.connect(`amqp://${user}:${password}@${host}:${port}`);
    }

    async startConsumer() {
        try {
            const connection = await this.createConnection();
            const channel = await connection.createChannel();

            const queueName = 'posts';
            await channel.assertQueue(queueName, {durable: true});

            console.log(`posts Queue consumer is waiting for messages...`);

            channel.consume(queueName, (msg) => {
                if (msg !== null) {
                    console.log("Received a message from `posts` queue");
                    const content = JSON.parse(msg.content.toString());
                    console.log(content);
                    console.log("Creating a notification...");
                    const message = this.messageFactory.createMessage(content.action);
                    this.notificationService.createNotification(content.postId, message).then(() => {
                        console.log("the Post notification successfully created");
                    }).finally(() => {
                        channel.ack(msg);
                    })
                } else {
                    console.log("An empty message received")
                }
            });
        } catch (error) {
            console.error('Error occurred:', error);
        }
    }
}
