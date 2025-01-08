import axios from "axios";

export function getVkUser(vkUserId, vkAccessToken)
{
    let url = 'https://api.vk.com/method/users.get';

    const params = {
        user_id: vkUserId,
        fields: 'contacts,bdate,military,city,sex',
        access_token: vkAccessToken,
        v: '5.199',
    };
    const headers = {
        'Content-Type': 'application/json'
    };

    return axios.get(url, {
        params: params,
        headers: headers
    });
}
