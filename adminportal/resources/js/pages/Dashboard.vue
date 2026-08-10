<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import { dashboard } from '@/routes';
import { destroy as destroyPharmacy, store as storePharmacy, update as updatePharmacy } from '@/routes/pharmacies';


type Pharmacy = {
    id: number;
    name: string;
    license_number: string;
    owner_name: string;
    owner_email:string;
    owner_phone: string;
    address: string;
    status: string;
    billing_cycle: Date;
    billing_status:string;
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
    inactiveCount:number;
    pharmacies: Pharmacy[];
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
    billing_status:''
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

const showEditModel=ref(false);
const editingPharmacy=ref<Pharmacy|null>(null);

const editForm=useForm({
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
    billing_status:''
});

function openEditModel(pharmacy: Pharmacy){
    editingPharmacy.value=pharmacy;
    editForm.name=pharmacy.name;
    editForm.license_number=pharmacy.license_number;
    editForm.address=pharmacy.address;
    editForm.owner_name=pharmacy.owner_name;
    editForm.owner_email=pharmacy.owner_email;
    editForm.owner_phone=pharmacy.owner_phone;
    editForm.status=pharmacy.status;
    editForm.billing_cycle=pharmacy.billing_cycle.toString();
    editForm.billing_date=new Date(pharmacy.billing_cycle).toISOString().slice(0,10);
    editForm.next_billing_date=new Date(pharmacy.billing_cycle).toISOString().slice(0,10);
    editForm.billing_status=pharmacy.billing_status;
    showEditModel.value=true;
}

function submitEdit(){
    editForm.put(updatePharmacy(editingPharmacy.value!.id).url,{
        preserveScroll:true,
        onSuccess:()=>{
            showEditModel.value=false
        },
    })
}

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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8  ">
            <div class="bg-white rounded-xl p-6 shahow-sm border transition duration-200 ease-out hover:-translate-y-1 hover:shadow-lg">
                <p class="text-sm text-black ">Total Pharmacies</p>
                <p class="text-2xl font-bold text-black justify-center flex">{{ props.pharmacyCount }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shahow-sm border transition duration-200 ease-out hover:-translate-y-1 hover:shadow-lg">
                <p class="text-sm text-black ">Active Pharmacies</p>
                <p class="text-2xl  font-bold text-black justify-center flex">{{ props.activeCount }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border transition duration-200 ease-out hover:-translate-y-1 hover:shadow-lg">
                <p class="text-sm text-slate-900">InActive Pharamcies</p>
                <p class="text-2xl fot-bold text-black justify-center flex">{{ props.inactiveCount }}</p>
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
                        <th class="px-2 py-2">Status</th>
                        <th class="px-2 py-2">Billing Cycle</th>
                        <th class="px-2 py-2">Billing Status</th>
                        <th class="px-2 py-2 ">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    <tr v-for="p in props.pharmacies" :key="p.id" class="border-t">
                        <td class="px-2 py-2 font-medium">{{ p.name }}</td>
                        <td class="px-2 py-2">{{ p.license_number }}</td>
                        <td class="px-2 py-2">{{ p.owner_name }}</td>
                        <td class="px-2 py-2">{{ p.address }}</td>
                        <td class="px-2 py-2">
                            <button class="px-2 py-1 rounded-full text-xs"
                                :class="{
                                'bg-green-100 text-green-800': p.status === 'active',
                                'bg-red-100 text-red-800': p.status === 'inactive',
                                'bg-slate-100 text-slate-600': !['active','inactive'].includes(p.status)}">
                                {{ p.status }}
                            </button></td>
                        <td class="px-2 py-2">{{ p.billing_cycle }}</td>
                        <td class="px-2 py-2">{{ p.billing_status }}</td>
                        <td class="px-2 py-2 ">
                                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-green-600 text-sm font-medium hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Update
                            </button>
                            <button @click="deletePharmacy(p.id)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-red-600 text-sm font-medium hover:bg-red-50 hover:text-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
    <!-- <div v-if="showModel" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
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
                        <option value="inactive">Inactive</option>
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
    </div> -->
    <div v-if="showModel" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <form @submit.prevent="submit"
            class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-xl text-slate-800">
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white rounded-t-2xl">
                <div>
                    <h2 class="text-lg font-bold text-slate-800"> + Register New Pharmacy</h2>
                    <p class="text-sm text-slate-400">Fill in the pharmacy and owner details below</p>
                </div>
            </div>

            <div class="px-6 py-5 space-y-6">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-indigo-500 mb-3">Pharmacy Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Pharmacy Name</label>
                            <input type="text" v-model="form.name" placeholder="e.g. Kampala Pharmacy"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">License Number</label>
                            <input type="text" v-model="form.license_number" placeholder="e.g. LIC-00123"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.license_number" class="text-red-500 text-xs mt-1">{{
                                form.errors.license_number }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Address</label>
                            <input type="text" v-model="form.address" placeholder="Street, city"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                            <select v-model="form.status"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <p v-if="form.errors.status" class="text-red-500 text-xs mt-1">{{ form.errors.status }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100"></div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-indigo-500 mb-3">Owner Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Owner Name</label>
                            <input type="text" v-model="form.owner_name" placeholder="Full name"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.owner_name" class="text-red-500 text-xs mt-1">{{ form.errors.owner_name
                                }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Owner Email</label>
                            <input type="email" v-model="form.owner_email" placeholder="name@example.com"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.owner_email" class="text-red-500 text-xs mt-1">{{
                                form.errors.owner_email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Telephone</label>
                            <input type="tel" v-model="form.owner_phone" inputmode="numeric" maxlength="20"
                                placeholder="e.g. 0700000000"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.owner_phone" class="text-red-500 text-xs mt-1">{{
                                form.errors.owner_phone }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100"></div>

                <!-- Billing details -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-indigo-500 mb-3">Billing Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Billing Cycle</label>
                            <select v-model="form.billing_cycle"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                            <p v-if="form.errors.billing_cycle" class="text-red-500 text-xs mt-1">{{
                                form.errors.billing_cycle }}</p>
                        </div>
                              <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Billing Status</label>
                            <select v-model="form.billing_status"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                            </select>
                            <p v-if="form.errors.billing_status" class="text-red-500 text-xs mt-1">{{form.errors.billing_status }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Billing Date</label>
                            <input type="date" v-model="form.billing_date"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.billing_date" class="text-red-500 text-xs mt-1">{{
                                form.errors.billing_date }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Next Billing Date</label>
                            <input type="date" v-model="form.next_billing_date"
                                class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p v-if="form.errors.next_billing_date" class="text-red-500 text-xs mt-1">{{
                                form.errors.next_billing_date }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100 bg-slate-50 rounded-b-2xl sticky bottom-0">
                <button type="button" @click="showModel = false"
                    class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-100 transition">
                    Cancel
                </button>
                <button type="submit" :disabled="form.processing"
                    class="px-5 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 disabled:opacity-50 transition">
                    {{ form.processing ? 'Saving...' : 'Register Pharmacy' }}
                </button>
            </div>
        </form>
    </div>
</template>
