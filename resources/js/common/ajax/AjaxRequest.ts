export default class AjaxRequest {
    private readonly _url: string;

    private readonly _args: Object;

    constructor(url: string, args: Object = {}) {
        this._url = url;
        this._args = args;
    }

    get url(): string {
        return this._url;
    }

    get args(): Object {
        return this._args;
    }
}
