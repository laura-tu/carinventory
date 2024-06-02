<template>
    <div class="outside-box">
        <h1 class="mb-4">Cars</h1>

        <form @submit.prevent="addCar" class="mb-4">
            <div class="mb-3 flex-first">
                <input
                    v-model="newCar.name"
                    class="form-control"
                    placeholder="Name"
                    required
                />

                <input
                    v-model="newCar.registration_number"
                    class="form-control"
                    placeholder="Registration Number"
                    :required="newCar.is_registered"
                />

                <div class="mb-3 form-check ml-3">
                    <input
                        type="checkbox"
                        v-model="newCar.is_registered"
                        class="form-check-input"
                        id="isRegistered"
                    />
                    <label class="form-check-label" for="isRegistered"
                        >Registered</label
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Car</button>
        </form>

        <table id="carsTable" class="display">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Registration Number</th>
                    <th>Registered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="car in cars" :key="car.id">
                    <td>{{ car.name }}</td>
                    <td>{{ car.registration_number }}</td>
                    <td>{{ car.is_registered }}</td>
                    <td>
                        <button @click="editCar(car)" class="btn btn-warning">
                            Edit
                            <i class="mdi mdi-table-edit"></i>
                        </button>
                        <button
                            @click="deleteCar(car.id)"
                            class="btn btn-danger"
                        >
                            Delete
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <edit-modal :show="isModalVisible" @close="isModalVisible = false">
            <template v-slot:body>
                <form @submit.prevent="updateCar">
                    <div class="mb-3">
                        <input
                            v-model="currentCar.name"
                            class="form-control"
                            placeholder="Name"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <input
                            v-model="currentCar.registration_number"
                            class="form-control"
                            placeholder="Registration Number"
                            :required="currentCar.is_registered"
                        />
                    </div>
                    <div class="mb-3 form-check">
                        <input
                            type="checkbox"
                            v-model="currentCar.is_registered"
                            class="form-check-input"
                            id="editIsRegistered"
                        />
                        <label class="form-check-label" for="editIsRegistered"
                            >Registered</label
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                </form>
            </template>
        </edit-modal>
    </div>
</template>

<script>
import EditModal from "./EditModal.vue";
import { initializeDataTable, destroyDataTable } from "../datatable-init";
import { useRouter } from 'vue-router';

export default {
    components: {
        EditModal,
    },
    data() {
        return {
            cars: [],
            newCar: {
                name: "",
                registration_number: "",
                is_registered: false,
            },
            currentCar: {
                id: null,
                name: "",
                registration_number: "",
                is_registered: false,
            },
            isModalVisible: false,
        };
    },
    setup() {
        const router = useRouter();

        const refreshPage = () => {
            router.go(); // Reload the current route
        };

        return { refreshPage };
    },
    mounted() {
        this.getCars();
    },
    updated() {
        this.$nextTick(() => {
            initializeDataTable("#carsTable");
        });
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
                const token = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch("/cars", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
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
                
                this.refreshPage();

            } catch (error) {
                console.error(error);
            }
        },
        async deleteCar(id) {
            try {
                const token = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch(`/cars/${id}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                });
                if (!response.ok) {
                    throw new Error("Failed to delete car");
                }
                this.getCars();
                this.refreshPage();

            } catch (error) {
                console.error(error);
            }
        },
        editCar(car) {
            this.currentCar = { ...car };
            this.isModalVisible = true;
        },
        async updateCar() {
            try {
                const token = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch(`/cars/${this.currentCar.id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify(this.currentCar),
                });
                if (!response.ok) {
                    throw new Error("Failed to update car");
                }
                this.getCars();
                this.isModalVisible = false;
               
            } catch (error) {
                console.error(error);
            }
        },
    },
    beforeDestroy() {
        if ($.fn.dataTable.isDataTable('#carsTable')) {
            $('#carsTable').DataTable().destroy();
        }
    },
};
</script>

<style scoped>
.outside-box {
    margin: 20px;
    font-family: "Reddit Mono", monospace;
}
.flex-first {
    display: flex;
    justify-content: space-between;
    width: 50%;
}
.form-control {
    margin-right: 5px;
}
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-container {
    background: white;
    padding: 20px;
    border-radius: 5px;
    width: 500px;
    max-width: 100%;
}
.modal-header,
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-body {
    margin-top: 10px;
    margin-bottom: 10px;
}
.close {
    cursor: pointer;
}
button{
    margin-right:1rem;
    text-transform: uppercase;
}
</style>
