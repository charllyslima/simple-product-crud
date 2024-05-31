interface IListResponse<T> {
    current_page: number
    data: [T]
    first_page_url: string
    from: string | null
    last_page: number
    last_page_url: string
    links: [Link]
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: string | null
    to: string | null
    total: number
}

interface Link {
    label:string
    active: boolean
    url: string | null
}