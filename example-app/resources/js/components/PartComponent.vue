<template>
    <div class="outside-box">
        <h1 class="mb-4">Parts</h1>

        <form @submit.prevent="addPart" class="mb-4">
            <div class="mb-3 flex-first">
                <input
                    v-model="newPart.name"
                    class="form-control"
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
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Part</button>
        </form>

        <table class="table table-striped">
            <thead class="thead-dark">
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
                        </button>
                        <button
                            @click="deletePart(part.id)"
                            class="btn btn-danger"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <custom-modal :show="isModalVisible" @close="isModalVisible = false">
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
        </custom-modal>
    </div>
</template>

<script>
import CustomModal from "./EditModal.vue";

export default {
    components: {
        CustomModal,
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
    mounted() {
        this.getParts();
        this.getCars();
    },
    methods: {
        async getParts() {
            try {
                const response = await fetch("/parts");
                if (!response.ok) {
                    throw new Error("Failed to fetch parts");
                }
                this.parts = await response.json();
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
};
</script>

<style scoped>
.outside-box {
    margin: 20px;
    font-family:"Reddit Mono",monospace;
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
    position: relative;
    width: 100%;
}

.select-wrapper select {
    /* Adjust padding to accommodate the down icon */
    padding-right: 30px;
}

.select-wrapper i {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none; /* Ensure the icon does not interfere with select box */
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
</style>
