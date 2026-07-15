<script setup lang="ts">
import { Head,Link, router,useForm } from '@inertiajs/vue3';
//import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { ref } from 'vue';

import { dashboard } from '@/routes';

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
const props=defineProps({
    pharmacyCount:Number,
    activeCount:Number,
    pharmacies:Array,
    billing_cycle:String,
    billing_status:String,
})

const showModel=ref(false)

const form= useForm({
    name:'',
    license_number:'',
    address:'',
    owner_name:'',
    owner_email:'',
    owner_phone:'',
    status:'',
    billing_cycle:'',
    subscription_fee:'',
    billing_date:'',
})
 function submit(){
    form.post(route('pharmacies.store'),{
        onSuccess:()=>{
            form.reset()
            showModel.value=false
        },
    })
 }
 function deletePharmacy(id:number){
    if(confirm('Delete this pharmacy?')){
        router.delete(route('pharmacies.destroy',{pharmacy:id}))
    
 }
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
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-xl p-6 shahow-sm border ">
                <p class="text-sm text-slate-500 ">Total Pharmacies</p>
                <p class="text-2xl font-bold">{{ props.pharmacyCount }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shahow-sm border">
                <p class="text-sm text-slate-500 ">Active Pharmacies</p>
                <p class="text-2xl  font-bold">{{ props.activeCount }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-200 text-slate-600">
                    <tr>
                        <th class="px-2 py-2">Pharmacy Name</th>
                        <th class="px-2 py-2">License Number</th>
                        <th class="px-2 py-2">Owner Name</th>
                        <th class="px-2 py-2">Address</th>
                        <th class="px-2 py-2">Status</th>
                        <th class="px-2 py-2 capitalize">{{ props.billing_cycle }}</th>
                        <th class="px-2 py-2">Billing Status</th>
                        <th class="px-2 py-2">Actions
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in props.pharmacies" :key="p.id" class="border-t">
                        <td class="px-2 py-2 font-medium">{{ p.name }}</td>
                        <td class="px-2 py-2">{{ p.license_number }}</td>
                        <td class="px-2 py-2">{{ p.owner_name }}</td>
                        <td class="px-2 py-2">{{ p.address }}</td>
                        <td class="px-2 py-2 capitalize">{{ p.status }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs" :class="p.status ==='active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                {{ p.status }}
                            </span>
                        </td>
                        <td class="px-2 py-2 text-right">
                            <button @click="deletePharmacy(p.id)" class="text-red-500 hover:text-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <!-- <tr v-if="props.pharmacies.length === 0">
                        <td colspan="8" class="px-2 py-2 text-center">
                            No Pharmacies registered yet.
                        </td>
                    </tr>  -->
                </tbody>
            </table>
        </div>
    </main>
    <div  v-if="showModel" class="fixed insert-0 bg-black/40 flex items-center justify-center z-10">
        <form @submit.prevent="submit" class="bg-white rounded-xl p-6 w-full max-w-md space-y-3 max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold">Register New Pharmacy</h2>
            <div>
                <label for="name" value="name">Pharmacy Name</label>
                <input input="text" v-model="form.name" placeholder="Pharmacy Name" class="w-full border rounded px-2 py-2">
                <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
            </div>
            <div>
                <label for="license_number" value="license_number">License Number</label>
                <input input="text" v-model="form.license_number" placeholder="License Number" class="w-full border rounded px-2 py-2">
                <p v-if="form.errors.license_number" class="text-red-500 text-xs mt-1">{{ form.errors.license_number }}</p>
            </div>
            <div>
                <label for="name" value="owner_name">Owner Name</label>
                <input input="text" v-model="form.owner_name" placeholder="Owner_name" class="w-full border rounded px-2 py-2">
                <p v-if="form.errors.owner_name" class="text-red-500 text-xs mt-1">{{ form.errors.owner_name }}</p>
            </div>
            <div>
                <label for="address" value="address">Address</label>
                <input input="text" v-model="form.address" placeholder="Address" class="w-full border rounded px-2 py-2">
                <p v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</p>
            </div>
            
        </form>

    </div>
</template>
