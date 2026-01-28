<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = withDefaults(
    defineProps<{
        transactions?: {
            id: number;
            type: 'income' | 'expense';
            description: string;
            amount: number;
        }[];
    }>(),
    {
        transactions: () => [],
    },
);

const type = ref<'income' | 'expense'>('income');
const description = ref('');
const amount = ref<number | null>(null);

const submit = () => {
    router.post('/transactions', {
        type: type.value,
        description: description.value,
        amount: amount.value,
    });

    description.value = '';
    amount.value = null;
};

// FIX: Add default value of 0 to handle empty arrays
const totalIncome = computed(() => {
    const total = props.transactions
        .filter((t) => t.type === 'income')
        .reduce((sum: number, t) => sum + (Number(t.amount) || 0), 0);
    return total || 0; // Ensure it's always a number
});

const totalExpenses = computed(() => {
    const total = props.transactions
        .filter((t) => t.type === 'expense')
        .reduce((sum: number, t) => sum + (Number(t.amount) || 0), 0);
    return total || 0; // Ensure it's always a number
});

const balance = computed(() => {
    return (totalIncome.value || 0) - (totalExpenses.value || 0);
});

const deleteTransaction = (id: number) => {
    router.delete(`/transactions/${id}`);
};

// Helper function for safe formatting
const formatAmount = (value: number): string => {
    const num = Number(value);
    return isNaN(num) ? '0.00' : num.toFixed(2);
};

</script>

<template>
    <AppLayout>
        <Head title="Transactions" />
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="mb-6 text-2xl font-semibold">My Transactions</h2>

                        <!-- Summary -->
                        <div class="mb-6 grid grid-cols-3 gap-4 text-center">
                            <div class="rounded border p-4 dark:border-gray-700">
                                <p class="text-xs uppercase text-gray-500 dark:text-gray-400">Income</p>
                                <p class="text-lg font-semibold text-green-600">
                                    €{{ formatAmount(totalIncome) }}
                                </p>
                            </div>
                            <div class="rounded border p-4 dark:border-gray-700">
                                <p class="text-xs uppercase text-gray-500 dark:text-gray-400">Expenses</p>
                                <p class="text-lg font-semibold text-red-600">
                                    €{{ formatAmount(totalExpenses) }}
                                </p>
                            </div>
                            <div class="rounded border p-4 dark:border-gray-700">
                                <p class="text-xs uppercase text-gray-500 dark:text-gray-400">Balance</p>
                                <p
                                    class="text-lg font-semibold"
                                    :class="balance >= 0 ? 'text-green-600' : 'text-red-600'"
                                >
                                    €{{ formatAmount(balance) }}
                                </p>
                            </div>
                        </div>

                        <!-- Add Transaction -->
                        <form @submit.prevent="submit" class="mb-6 flex flex-col gap-4">
                            <div class="flex gap-2">
                                <select v-model="type" class="w-1/3 rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700">
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>

                                <input
                                    v-model="description"
                                    type="text"
                                    placeholder="Description"
                                    class="flex-1 rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700"
                                    required
                                />
                            </div>

                            <div class="flex gap-2">
                                <input
                                    v-model.number="amount"
                                    type="number"
                                    step="0.01"
                                    placeholder="Amount"
                                    class="flex-1 rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700"
                                    required
                                />
                                <button
                                    type="submit"
                                    class="rounded bg-blue-600 px-6 py-2 text-white hover:bg-blue-700"
                                >
                                    Add Transaction
                                </button>
                            </div>
                        </form>

                        <!-- Transactions List -->
                        <div v-if="transactions.length > 0" class="divide-y rounded border dark:divide-gray-700 dark:border-gray-700">
                            <div
                                v-for="t in transactions"
                                :key="t.id"
                                class="flex items-center justify-between p-3"
                            >
                                <div>
                                    <p class="font-medium">{{ t.description }}</p>
                                    <p
                                        class="text-sm"
                                        :class="t.type === 'income' ? 'text-green-600' : 'text-red-600'"
                                    >
                                        {{ t.type }} · €{{ formatAmount(t.amount) }}
                                    </p>
                                </div>

                                <button
                                    @click="deleteTransaction(t.id)"
                                    class="text-sm text-red-500 hover:underline"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                        <div v-else class="rounded border p-8 text-center text-gray-500 dark:border-gray-700">
                            <p>No transactions yet. Add your first transaction above!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>