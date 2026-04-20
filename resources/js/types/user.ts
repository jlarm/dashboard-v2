export type User = {
    id: number;
    name: string;
    slug: string;
    email: string;
    role: string;
    completed_courses_count: number;
}

export type DeletedUser = {
    id: number;
    name: string;
    email: string;
    role: string;
    deleted_at: string;
}

export type OpenInvite = {
    id: number;
    name: string;
    email: string;
    role: string;
    created_at: string;
    expires_at: string;
}
