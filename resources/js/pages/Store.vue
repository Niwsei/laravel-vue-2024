<template>
    <div>
        <div class="card">
            <h5 class="card-header">ລາຍການສະຕ໊ອກສຶນຄ້າ</h5>
            <div class="card-body">
                <div class="form" v-if="ShowForm">
                    <div class="text-end">
                        <button
                            class="btn btn-info me-2"
                            @click="SaveStore()"
                            :disabled="CheckForm"
                        >
                            ບັນທຶກ
                        </button>
                        <button class="btn btn-danger" @click="CancelStore()">
                            ຍົກເລິກ
                        </button>
                    </div>
                    <!--   {{ FormStore }} -->
                    <div class="row">
                        <div
                            class="col-md-3 text-center"
                            style="position: relative"
                        >
                            <button
                                type="button"
                                class="btn rounded-pill btn-icon btn-danger"
                                v-if="FormStore.image"
                                @click="RemoveImg()"
                                style="position: absolute; right: 0; top: 0"
                            >
                                <span class="bx bx-trash fs-5"></span>
                            </button>
                            <img
                                :src="image_preview"
                                alt=""
                                @click="$refs.img_store.click()"
                                class="cursor-pointer rounded"
                                style="width: 80%"
                            />
                            <input
                                type="file"
                                ref="img_store"
                                style="display: none"
                                @change="onSelect"
                            />
                        </div>

                        <div class="col-md-9">
                            <div class="mb-2">
                                <label
                                    class="form-label fs-5"
                                    for="product_name "
                                    >ຊື່ສິນຄ້າ:</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="product_name "
                                    v-model="FormStore.name"
                                />
                            </div>

                            <div class="mb-2">
                                <label
                                    class="form-label fs-5"
                                    for="product_amount "
                                    >ຈຳນວນ:</label
                                >
                                <cleave
                                    :options="options"
                                    class="form-control"
                                    id="product_amount "
                                    v-model="FormStore.amount"
                                />
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label
                                            class="form-label fs-5"
                                            for="product_price_buy "
                                            >ລາຄາຊື່:</label
                                        >
                                        <cleave
                                            :options="options"
                                            class="form-control"
                                            id="product_price_buy"
                                            v-model="FormStore.price_buy"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label
                                            class="form-label fs-5"
                                            for="product_price_sell "
                                            >ລາຄາຂາຍ:</label
                                        >
                                        <cleave
                                            :options="options"
                                            class="form-control"
                                            id="product_price_sell"
                                            v-model="FormStore.price_sell"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap" v-if="!ShowForm">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="d-flex flex-column">
                            <!-- <h1>ລາຍການສຶນຄ້າ</h1> -->
                            <div class="d-flex align-items-center me-2">
                                <div
                                    class="d-flex justify-content-center me-2 cursor-pointer"
                                    @click="ChangSort()"
                                >
                                    <i
                                        class="bx bx-sort-up fs-3 me-2"
                                        v-if="Sort == 'asc'"
                                    ></i>
                                    <i
                                        class="bx bx-sort-down fs-3 me-2"
                                        v-else
                                    ></i>
                                </div>
                                <select
                                    class="form-select fs-6"
                                    v-model="PerPage"
                                    @change="GetStore()"
                                >
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex align-items-end">
                            <input
                                type="text"
                                class="form-control me-2"
                                placeholder="ຄົ້ນຫາ....."
                                v-model="Search"
                                @keyup.enter="GetStore()"
                            />
                            <button @click="AddStore()" class="btn btn-primary">
                                <i class="bx bx-user-plus me-1 fs-5"></i
                                >ເພີ່ມຂໍ້ມູນ
                            </button>
                        </div>
                        <!-- {{ StoreData }} -->
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th
                                    style="
                                        color: black;
                                        font-size: 15px;
                                        font-weight: bold;
                                        letter-spacing: -1px;
                                    "
                                    width="30"
                                >
                                    ID
                                </th>
                                <th
                                    style="
                                        color: black;
                                        font-size: 15px;
                                        font-weight: bold;
                                        letter-spacing: -1px;
                                        width: 120px;
                                    "
                                >
                                    ຮູບ
                                </th>
                                <th
                                    style="
                                        color: black;
                                        font-size: 15px;
                                        font-weight: bold;
                                        letter-spacing: -1px;
                                    "
                                >
                                    ຊື່ສຶນຄ້າ
                                </th>
                                <th width="120" style="
                                        color: black;
                                        font-size: 15px;
                                        font-weight: bold;
                                        letter-spacing: -1px;
                                        text-align: center;" 
                                    >ຈຳນວນ</th>
                                <th
                                    style="
                                        color: black;
                                        font-size: 15px;
                                        font-weight: bold;
                                        letter-spacing: -1px;
                                    "
                                    width="120"
                                    class="text-center"
                                >
                                    ລາຄາຊື່
                                </th>
                                <th
                                    style=" color: black; font-size: 15px;font-weight: bold; letter-spacing: -1px;  "
                        width="30"
                                >
                                    ຈັດການ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in StoreData.data" :key="list.id">
                                <td>{{ list.id }}</td>
                                <td>
                                    <img
                                        :src="url + '/assets/img/' + list.image"
                                        v-if="list.image"
                                        class="rounded"
                                        style="width: 100%"
                                        alt=""
                                    />
                                    <img
                                        :src="url + '/assets/img/download.jpeg'"
                                        v-else
                                        class="rounded"
                                        style="width: 100%"
                                        alt=""
                                    />
                                </td>
                                <td>
                                    {{ list.name }}
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-label-warning me-1">{{
                                        formatPrice(list.amount)
                                    }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-label-warning me-1">{{
                                        formatPrice(list.price_buy)
                                    }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button
                                            type="button"
                                            class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"
                                        >
                                            <i
                                                class="bx bx-dots-vertical-rounded"
                                            ></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a
                                                class="dropdown-item"
                                                href="javascript:void(0);"
                                                @click="CopyStore(list.id)"
                                                ><i
                                                    class="bx bx-copy-alt me-1"
                                                ></i>
                                                ກອບປີ້</a
                                            >
                                            <a
                                                class="dropdown-item"
                                                href="javascript:void(0);"
                                                @click="EditStore(list.id)"
                                                ><i
                                                    class="bx bx-edit-alt me-1"
                                                ></i>
                                                ເເກ້ໄຂ</a
                                            >
                                            <a
                                                class="dropdown-item"
                                                href="javascript:void(0);"
                                                @click="DeleteStore(list.id)"
                                                ><i
                                                    class="bx bx-trash me-1"
                                                ></i>
                                                ລົບຂໍ້ມູນ</a
                                            >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination
                        :pagination="StoreData"
                        :offset="5"
                        @paginate="GetStore($event)"
                    />
                    <button @click="showAlert">Hello World</button>
                </div>
            </div>
        </div>

        <!-- <input type="text" v-model="text">
<button @click="add()" style="padding: 1px 20px; margin-left:10px ; border: none; background-color: black; color: white;cursor: pointer;">submit</button>
   -->
    </div>
</template>

<script>
import { useStore } from "../Store/auth";
import axios from "axios";
export default {
    name: "Minipos14Store",

    data() {
        return {
            url: window.location.origin,
            image_preview: window.location.origin + "/assets/img/web_dnd.png",
            text: "",
            FormType: true,
            ShowForm: false,
            EditID: "",
            FormStore: {
                name: "",
                image: "",
                amount: "",
                price_buy: "",
                price_sell: "",
            },
            StoreData: [],
            Sort: "asc",
            PerPage: "5",
            Search: "",

            options: {
                // prefix: 'K ',
                numeral: true,
                numeralPositiveOnly: true,
                noImmediatePrefix: true,
                rawValueTrimPrefix: true,
                numeralIntegerScale: 10,
                numeralDecimalScale: 2,
                numeralDecimalMark: ",",
                delimiter: ".",
            },
        };
    },

    computed: {
        CheckForm() {
            if (
                this.FormStore.name == "" ||
                this.FormStore.amount == "" ||
                this.FormStore.price_buy == "" ||
                this.FormStore.price_sell == ""
            ) {
                return true;
            } else {
                return false;
            }
        },
    },

    setup() {
        const store = useStore();
        return { store };
    },

    methods: {
        RemoveImg() {
            this.FormStore.image = "";
            if (this.FormStore.image == "") {
                this.image_preview =
                    window.location.origin + "/assets/img/web_dnd.png";
            } else {
                image = this.FormStore.image;
            }
        },

        onSelect(event) {
            /* console.log(event.target.files[0]) */
            this.FormStore.image = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.FormStore.image);
            reader.addEventListener(
                "load",
                function () {
                    this.image_preview = reader.result;
                }.bind(this),
                false
            );
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        showAlert() {
            this.$swal({
                icon: "success",
                text: "hello world",
                title: "????",
                showConfirmButton: false,
                timer: 1800,
                toast: true,
                position: "top",
            });
        },
        add() {
            localStorage.setItem("web_token", this.text);

            /* this.store.set_token(this.text); */
        },

        AddStore() {
            this.ShowForm = true;
            this.FormType = true;
            this.FormStore.name = "";
            this.FormStore.image = "";
            this.FormStore.amount = "";
            this.FormStore.price_buy = "";
            this.FormStore.price_sell = "";
            this.image_preview =
                window.location.origin + "/assets/img/web_dnd.png";
        },

        CancelStore() {
            this.ShowForm = false;
        },
        EditStore(id) {
            console.log(id);
            this.FormType = false;
            this.EditID = id;

            axios
                .get(`api/store/edit/${id}`, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer" + this.store.get_token,
                    },
                })
                .then((res) => {
                    this.FormStore = res.data;

                    if (res.data.image) {
                        this.image_preview =
                            this.url + "/assets/img/" + res.data.image;
                    } else {
                        this.image_preview =
                            this.url + "/assets/img/web_dnd.png";
                    }

                    this.ShowForm = true;
                })
                .catch((error) => {
                    console.log("err :", error);

                    if (error) {
                        if (error.response.status == 401) {
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem("web_token");
                            localStorage.removeItem("user_token");
                            this.$router.push("/login");
                        }
                    }
                });
        },

        CopyStore(id) {
            console.log(id);
            this.FormType = true;
            this.EditID = id;

            axios
                .get(`api/store/edit/${id}`, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer" + this.store.get_token,
                    },
                })
                .then((res) => {
                    this.FormStore = res.data;
                    this.ShowForm = true;
                })
                .catch((error) => {
                    console.log("err :", error);

                    if (error) {
                        if (error.response.status == 401) {
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem("web_token");
                            localStorage.removeItem("user_token");
                            this.$router.push("/login");
                        }
                    }
                });
        },

        DeleteStore(id) {
            this.$swal({
                icon: "warning",
                text: "ທີ່ຈະລືບຂໍ້ມູນນີ້",
                title: "ທ່ານເເນ່ໃຈບໍ ?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ຕົກລົງ",
                cancelButtonText: "ຍົກເລິກ",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`api/store/delete/${id}`, {
                            headers: {
                                Authorization: "Bearer" + this.store.get_token,
                            },
                        })
                        .then((res) => {
                            if (res.data.success) {
                                this.GetStore();

                                this.$swal({
                                    title: "asdasdasd",
                                    text: "asdasdasda",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            } else {
                                this.$swal({
                                    title: res.data.message,
                                    text: "ການລືບຂໍ້ມູນ",
                                    icon: "error",
                                });
                            }
                        })
                        .catch((error) => {
                            console.log("err :", error);

                            if (error) {
                                if (error.response.status == 401) {
                                    this.store.remove_token();
                                    this.store.remove_user();
                                    localStorage.removeItem("web_token");
                                    localStorage.removeItem("user_token");
                                    this.$router.push("/login");
                                }
                            }
                        });
                }
            });
        },

        SaveStore() {
            if (this.FormType) {
                //
                axios
                    .post("api/store/add", this.FormStore, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: "Bearer" + this.store.get_token,
                        },
                    })
                    .then((res) => {
                        if (res.data.success) {
                            this.ShowForm = false;
                            this.GetStore();

                            this.$swal({
                                position:'center',
                                toast:true,
                                icon: 'success',
                                title: res.data.message,
                                showConfirmButton: false,
                                timer: 1800,
                            });
                        }
                        else{
                            this.$swal({
                                title: res.data.message,
                                icon:'error',
                                showConfirmButton:false,
                                timer:1800
                            })
                        }
                    })
                    .catch((error) => {
                        console.log("err:", error);
                        this.$swal({
                            icon: "error",
                            text: "hello world",
                            title: error.message,
                            showConfirmButton: false,
                            timer: 1800,
                        });

                        if (error) {
                            if (error.response.status == 401) {
                                this.store.remove_token();
                                this.store.remove_user();
                                localStorage.removeItem("web_token");
                                localStorage.removeItem("user_token");
                                this.$router.push("/login");
                            }
                        }
                    });
            } else {
                // update StoreData
                axios
                    .post(`api/store/update/${this.EditID}`, this.FormStore, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: "Bearer" + this.store.get_token,
                        },
                    })
                    .then((res) => {
                        if (res.data.success) {
                            this.ShowForm = false;
                            this.GetStore();
                        }
                    })
                    .catch((error) => {
                        console.log("err:", error);

                        if (error) {
                            if (error.response.status == 401) {
                                this.store.remove_token();
                                this.store.remove_user();
                                localStorage.removeItem("web_token");
                                localStorage.removeItem("user_token");
                                this.$router.push("/login");
                            }
                        }
                    });
            }
        },

        GetStore(page) {
            axios
                .get(
                    `api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`,
                    {
                        headers: {
                            Authorization: "Bearer" + this.store.get_token,
                        },
                    }
                )
                .then((res) => {
                    this.StoreData = res.data;
                })
                .catch((error) => {
                    console.log("err:", error);
                    if (error) {
                        if (error.response.status == 401) {
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem("web_token");
                            localStorage.removeItem("user_token");
                            this.$router.push("/login");
                        }
                    }
                });
        },

        ChangSort() {
            if (this.Sort == "asc") {
                this.Sort = "desc";
            } else {
                this.Sort = "asc";
            }
            this.GetStore();
        },
    },
    created() {
        this.GetStore();
    },

    watch: {
        // Watch lifecycle เเม่นการติิดตาม
        Search() {
            if (this.Search == "" || this.Search.length > 0) {
                this.GetStore();
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
