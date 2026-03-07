export type Department = {
    id: number;
    code: string;
    name: string;
    created_at: string;
    updated_at: string;
}

export type Employee = {
    id: number;
    employee_number: string;
    first_name: string;
    last_name: string;
    email?: string;
    position: string;
    status: 'active' | 'inactive';
    user_id: number;
    department_id: number | null;
    department?: Department;
    created_at: string;
    updated_at: string;
}

