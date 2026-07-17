<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import { dashboard } from '@/routes';
import { destroy as destroyPharmacy, store as storePharmacy } from '@/routes/pharmacies';


type Pharmacy = {
    id: number;
    name: string;
    license_number: string;
    owner_name: string;
    address: string;
    status: string;
    billing_cycle:Date;

};

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Admin Dashboard',
                href: dashboard(),
            },
        ],
    },
});

const props = defineProps<{
    pharmacyCount: number;
    activeCount: number;
    pharmacies: Pharmacy[];
    billing_cycle: string;
    billing_status: string;
}>();

const showModel = ref(false);

const form = useForm({
    name: '',
    license_number: '',
    address: '',
    owner_name: '',
    owner_email: '',
    owner_phone: '',
    status: '',
    billing_cycle: '',
    billing_date: new Date().toISOString().slice(0, 10),
    next_billing_date: new Date().toISOString().slice(0, 10),
});

function submit() {
    form.post(storePharmacy().url, {
        onSuccess: () => {
            form.reset();
            showModel.value = false;
        },
    });
}

function deletePharmacy(id: number) {
    if (confirm('Delete this pharmacy?')) {
        router.delete(destroyPharmacy(id).url);
    }
}
// function updatePharmacy(id: number){
//     if(confirm('Update This Pharmacy?')){
//         router.update(updatePharmacy(id).url);
//     }
// }
</script>

<template>
    <Head title="PharmaTech Solutions" />
    <main class="flex-1 p-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">OverView</h1>
            <button @click="showModel = true"
                class="px-4 py-2 bg-[#16f529]-600 text-white rounded-lg  border-3 hover:bg-[#16f529] focus:outline-none focus:ring-2 focus:ring-[#16f529] focus:ring-offset-2">
                + Register New Pharmacy
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-xl p-6 shahow-sm border ">
                <p class="text-sm text-black ">Total Pharmacies</p>
                <p class="text-2xl font-bold text-black">{{ props.pharmacyCount }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shahow-sm border">
                <p class="text-sm text-black ">Active Pharmacies</p>
                <p class="text-2xl  font-bold text-black justify-end flex">{{ props.activeCount }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-200 text-gray-600">
                    <tr>
                        <th class="px-2 py-2">Pharmacy Name</th>
                        <th class="px-2 py-2">License Number</th>
                        <th class="px-2 py-2">Owner Name</th>
                        <th class="px-2 py-2">Address</th>
                        <th class="px-2 py-2">Billing Cycle</th>
                        <th class="px-2 py-2">Billing Status</th>
                        <th class="px-2 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    <tr v-for="p in props.pharmacies" :key="p.id" class="border-t">
                        <td class="px-2 py-2 font-medium">{{ p.name }}</td>
                        <td class="px-2 py-2">{{ p.license_number }}</td>
                        <td class="px-2 py-2">{{ p.owner_name }}</td>
                        <td class="px-2 py-2">{{ p.address }}</td>
                        <td class="px-2 py-2">{{ p. billing_cycle}}</td>
                        <td class="px-2 py-2">
                        <!-- <td class="px-4 py-3"> -->
                            <button  class="px-2 py-1 rounded-full text-xs" :class="p.status ==='active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                {{ p.status }}
                            </button>
                        </td>
                        <td class="px-2 py-2 ">
                            <button
                                @click="deletePharmacy(p.id)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-red-600 text-sm font-medium hover:bg-red-50 hover:text-red-700 transition-colors"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                                </button>
                        </td>
                    </tr>
                    <tr v-if="props.pharmacies.length === 0">
                        <td colspan="8" class="px-2 py-2 text-center">
                            No Pharmacies registered yet.
                        </td>
                    </tr>  
                </tbody>
            </table>
        </div>
    </main>
    <div v-if="showModel" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <form @submit.prevent="submit" class="bg-white rounded-xl p-6 w-full max-w-2xl space-y-4 max-h-[90vh] overflow-y-auto text-black">
            <h2 class="text-lg font-bold">Register New Pharmacy</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block mb-1">Pharmacy Name</label>
                    <input type="text" v-model="form.name" placeholder="Pharmacy Name" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                </div>
                <div>
                    <label for="license_number" class="block mb-1">License Number</label>
                    <input type="text" v-model="form.license_number" placeholder="License Number" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.license_number" class="text-red-500 text-xs mt-1">{{ form.errors.license_number }}</p>
                </div>
                <div>
                    <label for="owner_name" class="block mb-1">Owner Name</label>
                    <input type="text" v-model="form.owner_name" placeholder="Owner Name" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.owner_name" class="text-red-500 text-xs mt-1">{{ form.errors.owner_name }}</p>
                </div>
                <div>
                    <label for="owner_email" class="block mb-1">Owner Email</label>
                    <input type="email" v-model="form.owner_email" placeholder="Owner Email" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.owner_email" class="text-red-500 text-xs mt-1">{{ form.errors.owner_email }}</p>
                </div>
                <div>
                    <label for="address" class="block mb-1">Address</label>
                    <input type="text" v-model="form.address" placeholder="Address" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</p>
                </div>
                <div>
                    <label for="owner_phone" class="block mb-1">Telephone</label>
                    <input type="tel" v-model="form.owner_phone" inputmode="numeric" maxlength="20" placeholder="Contact" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.owner_phone" class="text-red-500 text-xs mt-1">{{ form.errors.owner_phone }}</p>
                </div>
                <div>
                    <label for="status" class="block mb-1">Status</label>
                    <select v-model="form.status" class="w-full border rounded px-2 py-2">
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    <p v-if="form.errors.status" class="text-red-500 text-xs mt-1">{{ form.errors.status }}</p>
                </div>
                <div>
                    <label for="billing_cycle" class="block mb-1">Billing Cycle</label>
                    <select v-model="form.billing_cycle" class="w-full border rounded px-2 py-2">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                    <p v-if="form.errors.billing_cycle" class="text-red-500 text-xs mt-1">{{ form.errors.billing_cycle }}</p>
                </div>
                <div>
                    <label for="billing_date" class="block mb-1">Billing Date</label>
                    <input type="date" v-model="form.billing_date" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.billing_date" class="text-red-500 text-xs mt-1">{{ form.errors.billing_date }}</p>
                </div>
                    <div>
                    <label for="next_billing_date" class="block mb-1">Next Billing Date</label>
                    <input type="date" v-model="form.next_billing_date" placeholder="Next billing date" class="w-full border rounded px-2 py-2">
                    <p v-if="form.errors.owner_name" class="text-red-500 text-xs mt-1">{{ form.errors.owner_name }}</p>
                </div>
            </div>
            <div class="flex justify-center gap-2 pt-2">
                <button type="button" @click="showModel = false" class="px-4 py-2 bg-[#16f529] text-white  rounded-lg ">Cancel</button>
                <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[#16f529] text-white rounded-lg disabled:opacity-50 ">
                    {{ form.processing? 'Saving...': 'Register Pharmacy' }}
                </button>
            </div>
        </form>
    </div>
</template>
