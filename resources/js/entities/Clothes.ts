export default class Clothes {
    private _id: number;

    private _name: string;

    private _photo: string;

    private _isChosen: boolean;

    constructor(id: number, name: string, photo: string, isChosen: boolean) {
        this._id = id;
        this._name = name;
        this._photo = photo;
        this._isChosen = isChosen;
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get name() {
        return this._name;
    }

    set name(value) {
        this._name = value;
    }

    get photo() {
        return this._photo;
    }

    set photo(value) {
        this._photo = value;
    }

    get isChosen(): boolean {
        return this._isChosen;
    }

    set isChosen(value: boolean) {
        this._isChosen = value;
    }
}
