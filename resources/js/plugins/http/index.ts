import { inject, type App } from 'vue'
import axios, { AxiosInstance } from 'axios'

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
export const plugin = {
    install: (app: App) => {
        const http = axios.create()

        http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
        app.config.globalProperties.$http = http

        app.provide('http', http)
    }
}

export const useHttp = (): AxiosInstance => {
    return inject<AxiosInstance>('http')!
}
