<template>
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mt-4">Курстар тізімі</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fas fa-plus-circle"></i> Жаңа курс қосу
            </button>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Басты бет</a></li>
            <li class="breadcrumb-item active">Курстар тізімі</li>
        </ol>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Активный курстар</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Архивный курстар</button>
            </li>
        </ul>
        <div class="tab-content mb-4" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered">
                    <caption>Тізімде бүкіл активты курстар</caption>
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Курс атауы</th>
                        <th>2022</th>
                        <th>2021</th>
                        <th>2020-ға дейін</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Әдістемелік</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Пән аралық</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-bordered">
                    <caption>Тізімде бүкіл архивты курстар</caption>
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Курс атауы</th>
                        <th>2022</th>
                        <th>2021</th>
                        <th>2020-ға дейін</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Әдістемелік</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Пән аралық</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal for create course -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="createCourseModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form v-on:submit.prevent="CreateCourse">
                    <div class="modal-header">
                        <h5 class="flex-fill modal-title text-center" id="exampleModalLabel">Жаңа курс қосу</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Курс атауы</label>
                            <input v-model="newCourse.name" v-bind:class="{'is-invalid': errors.name}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            <div class="invalid-feedback" v-if="errors.name" v-bind:class="{'d-block': errors.name}">{{ errors.name[0] }}</div>
                            <div class="form-text" v-else>Басқа курс атаумен бірдей болмағаны жөн</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Толық ақпарат</label>
                            <textarea v-model="newCourse.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            <div id="textHelp" class="form-text">Бос қалдыруға болады</div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                        <button type="submit" class="btn btn-primary">
                            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span v-else><i class="fas fa-check-circle"></i></span> Курсты Қосу
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Toast Message -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060">
            <div ref="toastOk" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle"></i> Жаңа курс қосылды
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div ref="toastErr" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-triangle"></i> Ощибка с сервером
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import * as courseService from '../services/course_service';
import { Toast } from 'bootstrap'

export default {
    name: "CoursesList",
    data() {
        return {
            newCourse: {
                name: '',
                description: ''
            },
            errors: {},
            toast: {
                ok: null,
                err: null
            },
            loading: false
        }
    },
    mounted() {
        this.toast.ok = new Toast(this.$refs.toastOk)
        this.toast.err = new Toast(this.$refs.toastErr)
    },
    methods: {
        hideModal() {
            this.$refs.closeModal.click()
        },
        CreateCourse: async function() {
            this.loading = true
            let formData = new FormData()
            formData.append('name', this.newCourse.name)
            formData.append('description', this.newCourse.description)

            try {
                const response = await courseService.createCourse(formData)
                console.log(response)
                this.errors = {}
                this.hideModal()
                this.toast.ok.show()
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    default:
                        this.toast.err.show()
                        break;
                }
            }
            this.loading = false;
        },

    }
}
</script>

<style scoped>

</style>
