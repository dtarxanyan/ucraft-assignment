import {Column, Entity, PrimaryGeneratedColumn} from 'typeorm';

@Entity()
export class PostNotification {
    @PrimaryGeneratedColumn()
    id: number;

    @Column()
    postId: number;

    @Column({length: 255})
    message: string;
}
