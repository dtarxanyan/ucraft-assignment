import {Injectable} from '@nestjs/common';
import {Actions} from "./types";

const ActionToMessageMap: { [Action in Actions]: string; } = {
    create: "Post successfully created",
    update: "The Post is updated",
    delete: "The Post was deleted"
}

@Injectable()
export class MessageFactory {

    createMessage(action: Actions) {
        return ActionToMessageMap[action];
    }
}