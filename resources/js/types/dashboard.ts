export type Log = {
    id: number;
    event_id: string;
    event_type: string;
    sender: string | null;
    recipient: string;
    delivery_status_message: string | null;
    delivery_status_code: string | null;
    delivery_status_severity: string | null;
    occurred_at: string;
    payload: Record<string, unknown> | unknown[];
};

export type EmailVolumePoint = {
    date: string;
    total: number;
};

export type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

export type PaginatedLogs = {
    data: Log[];
    meta: {
        from: number | null;
        to: number | null;
        total: number;
        current_page: number;
        last_page: number;
        links: PaginationLink[];
    };
};
