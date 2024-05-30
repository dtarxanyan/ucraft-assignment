import "reflect-metadata"
import {DataSource} from "typeorm"
import {PostNotification} from "./entity/PostNotification"

export default new DataSource({
    type: "postgres",
    host: 'db',
    port: 5432,
    username: 'postgres',
    password: 'postgres',
    database: 'notifications',
    synchronize: false,
    logging: false,
    entities: [PostNotification],
    migrations: ['src/migrations/*.ts'],
    subscribers: [],
});