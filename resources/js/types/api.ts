export type PaginatedLink = {
    url: string
    label: string
    active: boolean
}

export type PaginatedApiResponse<T> = {
    data: T[]
    meta: {
        current_page: Number
        from: Number
        last_page: Number
        links: PaginatedLink[]
        path: String
        per_page: Number
        to: Number
        total: Number
    }
    links: {
        first: String
        last: String
        prev: String | null
        next: String | null
    }
}
