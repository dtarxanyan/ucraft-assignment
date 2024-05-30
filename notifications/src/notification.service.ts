import {Injectable} from '@nestjs/common';
import {InjectRepository} from '@nestjs/typeorm';
import {Repository} from 'typeorm';
import {PostNotification} from './entity/PostNotification';

@Injectable()
export class NotificationService {
    constructor(
        @InjectRepository(PostNotification)
        private notificationRepository: Repository<PostNotification>,
    ) {
    }

    async createNotification(postId: number, message: string): Promise<PostNotification> {
        const notification = new PostNotification();
        notification.postId = postId;
        notification.message = message;
        return await this.notificationRepository.save(notification);
    }
}
