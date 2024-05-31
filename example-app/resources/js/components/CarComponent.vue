<template>
    <div>
        <h1 class="mb-4">Cars</h1>
        
        <form @submit.prevent="addCar" class="mb-4">
            <div class="mb-3">
                <input v-model="newCar.name" class="form-control" placeholder="Name" required />
            </div>
            <div class="mb-3">
                <input v-model="newCar.registration_number" class="form-control" placeholder="Registration Number" :required="newCar.is_registered" />
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" v-model="newCar.is_registered" class="form-check-input" id="isRegistered" />
                <label class="form-check-label" for="isRegistered">Registered</label>
            </div>
            <button type="submit" class="btn btn-primary">Add Car</button>
        </form>
        
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Registration Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="car in cars" :key="car.id">
                    <td>{{ car.name }}</td>
                    <td>{{ car.registration_number }}</td>
                    <td>
                        <button @click="deleteCar(car.id)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>



<script>
export default {
    data() {
        return {
            cars: [],
            newCar: {
                name: "",
                registration_number: "",
                is_registered: false,
            },
        };
    },
    mounted() {
        this.getCars();
    },
    methods: {
        async getCars() {
            try {
                const response = await fetch("/cars");
                if (!response.ok) {
                    throw new Error("Failed to fetch cars");
                }
                this.cars = await response.json();
            } catch (error) {
                console.error(error);
            }
        },
        async addCar() {
            try {
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content; // Get CSRF token from meta tag
                const response = await fetch("/cars", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token, // Include CSRF token in request headers
                    },
                    body: JSON.stringify(this.newCar),
                });
                if (!response.ok) {
                    throw new Error("Failed to add car");
                }
                this.getCars();
                this.newCar = {
                    name: "",
                    registration_number: "",
                    is_registered: false,
                };
            } catch (error) {
                console.error(error);
            }
        },
        async deleteCar(id) {
            try {
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content; // Get CSRF token from meta tag
                const response = await fetch(`/cars/${id}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token, // Include CSRF token in request headers
                    }
                });
                if (!response.ok) {
                    throw new Error("Failed to delete car");
                }
                this.getCars();
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
