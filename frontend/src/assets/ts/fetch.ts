
/** The default object you pass to the fetch functions. */
export interface Client {
    host_url: string
    api_prefix: string
    headers: HeadersInit
}

/** Default api params */
export const defaultClient: Client = {
    host_url: "http://localhost:8000",
    api_prefix: "/api",
    headers: {
        "Content-type": "application/json;charset=UTF-8",
    },
}

/**
 * ### GET URL/trivia
 * @param {Client} client init settings for the api client (url and headers)
 * @returns {Promise<Response>} Promise of the fetch request
 */
export async function FetchTrivia(client: Client): Promise<Response> {
    const url = `${client.host_url}${client.api_prefix}/trivia`;
    return await fetch(url, {
        method: "GET",
        headers: client.headers,
    });
}


export interface TriviaApiResponseInterface {
    year: string
    data: string[]
}
