export default class AjaxResponse {
    private readonly _success: boolean;

    private readonly _status: number;

    private readonly _data: any;

    constructor(success: boolean, status: number, response: any) {
        this._success = success;
        this._status = status;
        this._data = response;
    }

    get success(): boolean {
        return this._success;
    }

    get status(): number {
        return this._status;
    }

    get data(): any {
        return this._data;
    }
}
