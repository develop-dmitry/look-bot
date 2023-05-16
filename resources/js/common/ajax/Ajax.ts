import axios from 'axios';
import AjaxResponse from './AjaxResponse';
import type AjaxRequest from './AjaxRequest';

export default class Ajax {
    public static async post(request: AjaxRequest) {
        try {
            const response = await axios.post(request.url, request.args);
            console.log(response);
            return new AjaxResponse(
                response.data.success ?? true,
                response.status,
                response.data
            );
        } catch (error: any) {
            return new AjaxResponse(false, error.response.status, null);
        }
    }
}
