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
                    :required="newCar.registration_required"
                    @input="checkRegistration"
                />

                <div class="mb-3 form-check ml-3 block">
                    <input
                        type="checkbox"
                        v-model="newCar.is_registered"
                        class="form-check-input"
                        id="isRegistered"
                    />
                    <label class="form-check-label p-2" for="isRegistered">
                        Registered</label
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Car <i class="mdi mdi-plus"></i></button>
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

        <!--Edit modal-->
        <edit-modal :show="isModalVisible" @close="isModalVisible = false">
            <template v-slot:body>
                <form @submit.prevent="updateCar">
                    <div class="mb-3">
                        <input
                            v-model="currentCar.name"
                            class="form-control"
                            placeholder="Name"
                        />
                    </div>
                    <div class="mb-3">
                        <input
                            v-model="currentCar.registration_number"
                            class="form-control"
                            placeholder="Registration Number"
                            :required="currentCar.is_registered"
                            @input="checkRegistration"
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

        <!--Error modal-->
        <error-modal :show="showErrorModal" @close="showErrorModal = false">
            
            <template v-slot:header>
                <h5 class="modal-title">Error</h5>
            </template>
            <template v-slot:body>
                <p>{{ errorMessage }}</p>
            </template>
            
        </error-modal>
    </div>
</template>

<script>
import EditModal from "./EditModal.vue";
import ErrorModal from "./ErrorModal.vue"; // Import your error modal component
import { initializeDataTable, destroyDataTable } from "../datatable-init";
import { useRouter } from "vue-router";

export default {
    components: {
        EditModal,
        ErrorModal,
    },
    setup() {
        const router = useRouter();

        const refreshPage = () => {
            router.go(); // Reload the current route
        };
        return { refreshPage };
    },
    data() {
        return {
            cars: [],
            newCar: {
                name: "",
                registration_number: "",
                is_registered: false,
                registration_required: false,
            },
            currentCar: {
                id: null,
                name: "",
                registration_number: "",
                is_registered: "",
            },
            isModalVisible: false,
            showErrorModal: false,
            errorMessage: "",
        };
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
                // Check if registration number is empty and is_registered is true
                if (
                    this.newCar.is_registered &&
                    !this.newCar.registration_number.trim()
                ) {
                    // Set error message and show error modal
                    this.errorMessage =
                        "Registration number is required for a registered car.";
                    this.showErrorModal = true;
                    return; // Prevent further execution
                }

                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
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
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
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
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
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
        checkRegistration() {
            // If registration number is not empty, set is_registered to true
            if (
                this.newCar.registration_number &&
                this.newCar.registration_number.trim() !== ""
            ) {
                this.newCar.is_registered = true;
            } else {
                this.newCar.is_registered = false;
            }
        },
    },
    beforeDestroy() {
        if ($.fn.dataTable.isDataTable("#carsTable")) {
            $("#carsTable").DataTable().destroy();
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
button {
    margin-right: 1rem;
    text-transform: uppercase;
}
input {
    border: 1px black solid;
    padding-top: 5px;
    padding-bottom: 5px;
}
.form-check input {
    padding: 12px;
}
.block {
    display: flex;
    align-items: center;
    padding-right: 10px;
}
</style>
