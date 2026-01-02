<template>
    <Head title="Dashboard" />
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="khmer-text text-3xl font-bold text-white">ស្វាគមន៍មកកាន់ផ្ទាំងគ្រប់គ្រង</h1>
                <p class="mt-1 text-sm text-gray-400">Overview of your store performance</p>
            </div>
            <div class="text-sm text-gray-400">
                {{ currentDate }}
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Users Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-blue-500/30 p-6 text-white shadow-lg shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/20 hover:border-blue-500/50">
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-blue-500/20 p-3 backdrop-blur-sm border border-blue-500/30">
                            <Users class="h-8 w-8 text-blue-400" />
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium text-gray-300">អ្នកប្រើប្រាស់</h3>
                        <p class="text-4xl font-bold text-blue-400">{{ stats.users }}</p>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-emerald-500/30 p-6 text-white shadow-lg shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/20 hover:border-emerald-500/50">
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-emerald-500/20 p-3 backdrop-blur-sm border border-emerald-500/30">
                            <Package class="h-8 w-8 text-emerald-400" />
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium text-gray-300">ផលិតផលសរុប</h3>
                        <p class="text-4xl font-bold text-emerald-400">{{ stats.products }}</p>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-purple-500/30 p-6 text-white shadow-lg shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-500/20 hover:border-purple-500/50">
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-purple-500/20 p-3 backdrop-blur-sm border border-purple-500/30">
                            <ShoppingBag class="h-8 w-8 text-purple-400" />
                        </div>
                        <span v-if="stats.pendingOrders > 0"
                            class="rounded-full bg-red-500 px-2 py-1 text-xs font-bold">{{ stats.pendingOrders
                            }}</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium text-gray-300">ការបញ្ជាទិញសរុប</h3>
                        <p class="text-4xl font-bold text-purple-400">{{ stats.totalOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-amber-500/30 p-6 text-white shadow-lg shadow-amber-500/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-amber-500/20 hover:border-amber-500/50">
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-amber-500/20 p-3 backdrop-blur-sm border border-amber-500/30">
                            <DollarSign class="h-8 w-8 text-amber-400" />
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium text-gray-300">ប្រាក់ចំណូលសរុប</h3>
                        <p class="text-4xl font-bold text-amber-400">${{ formatNumber(stats.totalRevenue) }}</p>
                        <p class="text-xs text-gray-400">This month: ${{ formatNumber(stats.monthlyRevenue) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Sales Trend Chart -->
            <div class="rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 p-6 shadow-lg shadow-slate-900/50">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white">Sales Trend (Last 7 Days)</h2>
                    <TrendingUp class="h-5 w-5 text-green-400" />
                </div>
                <div class="h-80">
                    <Line :data="salesTrendData" :options="salesTrendOptions" />
                </div>
            </div>

            <!-- Orders by Status Pie Chart -->
            <div class="rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 p-6 shadow-lg shadow-slate-900/50">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white">Orders by Status</h2>
                    <PieChartIcon class="h-5 w-5 text-purple-400" />
                </div>
                <div class="h-80">
                    <Pie :data="ordersByStatusData" :options="pieChartOptions" />
                </div>
            </div>

            <!-- Top Products Bar Chart -->
            <div class="rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 p-6 shadow-lg shadow-slate-900/50">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white">Top Products (Last 30 Days)</h2>
                    <BarChart3 class="h-5 w-5 text-emerald-400" />
                </div>
                <div class="h-80">
                    <Bar :data="topProductsData" :options="barChartOptions" />
                </div>
            </div>

            <!-- Payment Status Donut Chart -->
            <div class="rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 p-6 shadow-lg shadow-slate-900/50">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white">Payment Status</h2>
                    <CreditCard class="h-5 w-5 text-blue-400" />
                </div>
                <div class="h-80">
                    <Doughnut :data="paymentStatusData" :options="doughnutChartOptions" />
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 p-6 shadow-lg shadow-slate-900/50">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Recent Orders</h2>
                <Link :href="route('dashboard.orders.index')"
                    class="text-sm text-purple-400 hover:text-purple-300 font-medium">
                    View All →
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-slate-700/50">
                        <tr class="text-left text-sm text-gray-400">
                            <th class="pb-3 font-medium">Order Number</th>
                            <th class="pb-3 font-medium">Customer</th>
                            <th class="pb-3 font-medium">Amount</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Payment</th>
                            <th class="pb-3 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in recentOrders" :key="order.id"
                            class="border-b border-slate-700/30 text-sm hover:bg-slate-700/30 transition-colors">
                            <td class="py-4">
                                <Link :href="`/dashboard/orders/${order.id}`"
                                    class="font-semibold text-purple-400 hover:text-purple-300">
                                    {{ order.order_number }}
                                </Link>
                            </td>
                            <td class="py-4 text-gray-300">{{ order.customer }}</td>
                            <td class="py-4 font-semibold text-gray-200">${{ parseFloat(order.total).toFixed(2) }}</td>
                            <td class="py-4">
                                <span :class="getStatusBadgeClass(order.status)">
                                    {{ order.status }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span :class="getPaymentStatusBadgeClass(order.payment_status)">
                                    {{ order.payment_status }}
                                </span>
                            </td>
                            <td class="py-4 text-gray-400">{{ order.created_at }}</td>
                        </tr>
                        <tr v-if="recentOrders.length === 0">
                            <td colspan="6" class="py-8 text-center text-gray-400">
                                No recent orders
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import {
    Users,
    Package,
    ShoppingBag,
    DollarSign,
    TrendingUp,
    PieChart as PieChartIcon,
    BarChart3,
    CreditCard
} from 'lucide-vue-next'
import { Line, Bar, Pie, Doughnut } from 'vue-chartjs'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    ArcElement
} from 'chart.js'

// Register Chart.js components
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    ArcElement
)

const props = defineProps({
    stats: {
        type: Object,
        required: true,
        default: () => ({
            users: 0,
            products: 0,
            totalOrders: 0,
            pendingOrders: 0,
            totalRevenue: 0,
            monthlyRevenue: 0
        })
    },
    charts: {
        type: Object,
        required: true,
        default: () => ({
            salesTrend: [],
            ordersByStatus: [],
            ordersByPaymentStatus: [],
            topProducts: []
        })
    },
    recentOrders: {
        type: Array,
        default: () => []
    }
})

// Colors for charts
const COLORS = ['#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444']
const PAYMENT_COLORS = ['#f59e0b', '#10b981', '#ef4444']

// Get current date in a nice format
const currentDate = computed(() => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date().toLocaleDateString('en-US', options)
})

// Format large numbers
const formatNumber = (num) => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
    }
    return num.toFixed(2)
}

// Sales Trend Chart Data
const salesTrendData = computed(() => ({
    labels: props.charts.salesTrend.map(item => item.date),
    datasets: [
        {
            label: 'Orders',
            data: props.charts.salesTrend.map(item => item.orders),
            borderColor: '#8b5cf6',
            backgroundColor: 'rgba(139, 92, 246, 0.1)',
            tension: 0.4,
            fill: true
        },
        {
            label: 'Revenue ($)',
            data: props.charts.salesTrend.map(item => item.revenue),
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            tension: 0.4,
            fill: true
        }
    ]
}))

const salesTrendOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'bottom'
        },
        tooltip: {
            mode: 'index',
            intersect: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: '#f0f0f0'
            }
        },
        x: {
            grid: {
                display: false
            }
        }
    }
}

// Orders by Status Chart Data
const ordersByStatusData = computed(() => ({
    labels: props.charts.ordersByStatus.map(item => item.name),
    datasets: [
        {
            data: props.charts.ordersByStatus.map(item => item.value),
            backgroundColor: COLORS,
            borderWidth: 0
        }
    ]
}))

const pieChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom'
        },
        tooltip: {
            callbacks: {
                label: function (context) {
                    const label = context.label || ''
                    const value = context.parsed || 0
                    const total = context.dataset.data.reduce((a, b) => a + b, 0)
                    const percentage = ((value / total) * 100).toFixed(0)
                    return `${label}: ${value} (${percentage}%)`
                }
            }
        }
    }
}

// Top Products Chart Data
const topProductsData = computed(() => ({
    labels: props.charts.topProducts.map(item => item.name),
    datasets: [
        {
            label: 'Sales',
            data: props.charts.topProducts.map(item => item.sales),
            backgroundColor: '#10b981',
            borderRadius: 8
        }
    ]
}))

const barChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: '#f0f0f0'
            }
        },
        x: {
            grid: {
                display: false
            }
        }
    }
}

// Payment Status Chart Data
const paymentStatusData = computed(() => ({
    labels: props.charts.ordersByPaymentStatus.map(item => item.name),
    datasets: [
        {
            data: props.charts.ordersByPaymentStatus.map(item => item.value),
            backgroundColor: PAYMENT_COLORS,
            borderWidth: 0
        }
    ]
}))

const doughnutChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom'
        },
        tooltip: {
            callbacks: {
                label: function (context) {
                    const label = context.label || ''
                    const value = context.parsed || 0
                    const total = context.dataset.data.reduce((a, b) => a + b, 0)
                    const percentage = ((value / total) * 100).toFixed(0)
                    return `${label}: ${value} (${percentage}%)`
                }
            }
        }
    },
    cutout: '60%'
}

// Status badge classes
const getStatusBadgeClass = (status) => {
    const baseClasses = 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium'
    const statusClasses = {
        pending: 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20 ring-inset',
        processing: 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20 ring-inset',
        shipped: 'bg-purple-50 text-purple-700 ring-1 ring-purple-600/20 ring-inset',
        completed: 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset',
        cancelled: 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset'
    }
    return `${baseClasses} ${statusClasses[status] || statusClasses.pending}`
}

const getPaymentStatusBadgeClass = (status) => {
    const baseClasses = 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium'
    const statusClasses = {
        pending: 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20 ring-inset',
        paid: 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset',
        failed: 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset'
    }
    return `${baseClasses} ${statusClasses[status] || statusClasses.pending}`
}
</script>
