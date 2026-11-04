import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Live salary-balance helper for the Record Payment form.
// Advances are deducted from the monthly salary, so salary + advance payouts
// for one employee/month can never exceed that employee's monthly salary.
window.paymentForm = (cfg) => ({
    salaries: cfg.salaries || {},
    committed: cfg.committed || {},
    employeeId: cfg.initial.employeeId || '',
    month: cfg.initial.month || '',
    type: cfg.initial.type || 'salary',
    amount: cfg.initial.amount || '',

    money(n) {
        return '$' + Number(n || 0).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    },

    get salary() {
        return Number(this.salaries[this.employeeId] || 0);
    },

    // Committed (non-voided) salary/advance rows for the chosen employee+month.
    get rows() {
        if (!this.employeeId || !this.month) return [];
        return (this.committed[this.employeeId] || []).filter((r) => r.month === this.month);
    },

    get advances() {
        return this.rows.reduce((s, r) => s + (r.type === 'advance' ? Number(r.amount) : 0), 0);
    },

    get paidSalary() {
        return this.rows.reduce((s, r) => s + (r.type === 'salary' ? Number(r.amount) : 0), 0);
    },

    get remaining() {
        return this.salary - this.advances - this.paidSalary;
    },

    get hasEmployee() {
        return !!this.employeeId && !!this.month;
    },

    get salaryCapped() {
        return this.hasEmployee && this.salary > 0;
    },

    // Only salary/advance draw down the budget; bonus/other are extra.
    get drawsBudget() {
        return this.type === 'salary' || this.type === 'advance';
    },

    get overpay() {
        return this.salaryCapped && this.drawsBudget && Number(this.amount) > this.remaining;
    },

    // Positive when there is still salary left to pay this month.
    get netPayable() {
        return this.remaining > 0 ? this.remaining : 0;
    },

    payNet() {
        if (this.netPayable > 0) this.amount = this.netPayable.toFixed(2);
    },
});

Alpine.start();
