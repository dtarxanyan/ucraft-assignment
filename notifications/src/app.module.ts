import {Module} from '@nestjs/common';
import {RabbitMQService} from './rabbitmq.service';
import {NotificationService} from './notification.service';
import {MessageFactory} from './message.factory';
import {TypeOrmModule} from '@nestjs/typeorm';
import {PostNotification} from './entity/PostNotification';
import {ConfigModule} from '@nestjs/config';

@Module({
    imports: [
        ConfigModule.forRoot({
            isGlobal: true,
        }),
        TypeOrmModule.forRoot({
            type: 'postgres',
            host: 'db',
            port: 5432,
            username: 'postgres',
            password: 'postgres',
            database: 'notifications',
            entities: [PostNotification],
            synchronize: true,
        }),
        TypeOrmModule.forFeature([PostNotification]),
    ],
    providers: [RabbitMQService, NotificationService, MessageFactory]

})
export class AppModule {
}
