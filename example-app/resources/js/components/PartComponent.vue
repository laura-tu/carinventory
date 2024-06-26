<template>
    <div class="outside-box">
        <h1 class="mb-4">Parts</h1>

        <form @submit.prevent="addPart" class="mb-4">
            <div class="mb-3 flex-first ">
                <input
                    v-model="newPart.name"
                    class="form-control "
                    placeholder="Name"
                    required
                />
                <input
                    v-model="newPart.serialnumber"
                    class="form-control"
                    placeholder="Serial Number"
                    required
                />
                <div class="select-wrapper">
                    <select
                        v-model="newPart.car_id"
                        class="form-control "
                        required
                    >
                        <option disabled value="">Select Car</option>
                        <option
                            v-for="car in cars"
                            :key="car.id"
                            :value="car.id"
                        >
                            {{ car.name }}
                        </option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Part <i class="mdi mdi-plus"></i></button>
        </form>

        <table id="partsTable" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Serial Number</th>
                    <th>Car</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="part in parts" :key="part.id">
                    <td>{{ part.name }}</td>
                    <td>{{ part.serialnumber }}</td>
                    <td>{{ part.car.name }}</td>
                    <td>
                        <button @click="editPart(part)" class="btn btn-warning">
                            Edit
                            <i class="mdi mdi-table-edit"></i>
                        </button>
                        <button
                            @click="deletePart(part.id)"
                            class="btn btn-danger"
                        >
                            Delete
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <edit-modal :show="isModalVisible" @close="isModalVisible = false">
            <template v-slot:body>
                <form @submit.prevent="updatePart">
                    <div class="mb-3">
                        <input
                            v-model="currentPart.name"
                            class="form-control"
                            placeholder="Name"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <input
                            v-model="currentPart.serialnumber"
                            class="form-control"
                            placeholder="Serial Number"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <select
                            v-model="currentPart.car_id"
                            class="form-control"
                            required
                        >
                            <option
                                v-for="car in cars"
                                :key="car.id"
                                :value="car.id"
                            >
                                {{ car.name }}
                            </option>
                        </select>
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
            parts: [],
            cars: [],
            newPart: {
                name: "",
                serialnumber: "",
                car_id: null,
            },
            currentPart: {
                id: null,
                name: "",
                serialnumber: "",
                car_id: null,
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
        this.getParts();
        this.getCars();
    },
    updated() {
        this.$nextTick(() => {
            initializeDataTable("#partsTable");
        });
    },
    methods: {
        async getParts() {
            try {
                const response = await fetch("/parts");
                if (!response.ok) {
                    throw new Error("Failed to fetch parts");
                }
                this.parts = await response.json();
                this.$nextTick(() => {
                    initializeDataTable("#partsTable");
                });
            } catch (error) {
                console.error(error);
            }
        },
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
        async addPart() {
            try {
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
                const response = await fetch("/parts", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify(this.newPart),
                });
                if (!response.ok) {
                    throw new Error("Failed to add part");
                }
                this.getParts();
                this.newPart = {
                    name: "",
                    serialnumber: "",
                    car_id: null,
                };

                this.refreshPage();

            } catch (error) {
                console.error(error);
            }
        },
        async deletePart(id) {
            try {
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
                const response = await fetch(`/parts/${id}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                });
                if (!response.ok) {
                    throw new Error("Failed to delete part");
                }
                this.getParts();
                this.refreshPage();

            } catch (error) {
                console.error(error);
            }
        },
        editPart(part) {
            this.currentPart = { ...part };
            this.isModalVisible = true;
        },
        async updatePart() {
            try {
                const token = document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
                const response = await fetch(`/parts/${this.currentPart.id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify(this.currentPart),
                });
                if (!response.ok) {
                    throw new Error("Failed to update part");
                }
                this.getParts();
                this.isModalVisible = false;
            } catch (error) {
                console.error(error);
            }
        },
    },
    beforeDestroy() {
        destroyDataTable("#partsTable");
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
    margin-right: 4px;
}
.select-wrapper { 
    width: 100%;
}

.modal-overlay {
    /*position: fixed;
      top: 0;
      left: 0;*/
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
input,select{
    border: 1px black solid;
    margin-top: 5px;
    padding-top: 5px; 
    padding-bottom: 5px;  
    height: 50px;  
    line-height: 30px;  
    font-size: 16px;  
}

</style>
