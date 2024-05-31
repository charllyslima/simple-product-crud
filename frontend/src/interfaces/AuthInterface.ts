interface ResponseLogin {
    success: boolean
    message: string
    data: FormLoginResponseError | FormLoginResponse
}

interface FormLoginResponseError {
    email?: [string] | []
    password?: [string] | []
    message?: string
}

interface FormLoginResponse {
    name: string
    token: string
}
