import EventEmitter from "events";

class CaretakerEventEmitter extends EventEmitter { };

export const caretakerEvents = new CaretakerEventEmitter();