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
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                    Активный курстар
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                    Архивный курстар
                </button>
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
                        <th>Толық ақпарат</th>
                        <th>2022</th>
                        <th>2021</th>
                        <th>2019 жане оған дейін</th>
                        <th><i class="fas fa-cog"></i> Қызмет түрлері</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(course, index) in coursesList" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ course.name }}</td>
                        <td>{{ course.description }}</td>
                        <td>106</td>
                        <td>505</td>
                        <td>505</td>
                        <td>
                            <button v-on:click="editCourse(course)" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өзгерту"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-secondary btn-sm"><i class="fas fa-power-off"></i> Архивтау</button>
                            <button v-on:click="deleteCourse(course)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өшіру"><i class="fas fa-trash"></i></button>
                        </td>
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
                    <form v-on:submit.prevent="createCourse">
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
        <!-- Modal for edit course -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="editCourseModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form v-on:submit.prevent="updateCourse()">
                        <div class="modal-header">
                            <h5 class="flex-fill modal-title text-center" id="editModalLabel">Курсты өзгерту</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Курс атауы</label>
                                <input v-model="editCourseData.name" v-bind:class="{'is-invalid': errors.name}" type="text" class="form-control" aria-describedby="emailHelp" required>
                                <div class="invalid-feedback" v-if="errors.name" v-bind:class="{'d-block': errors.name}">{{ errors.name[0] }}</div>
                                <div class="form-text" v-else>Басқа курс атаумен бірдей болмағаны жөн</div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Толық ақпарат</label>
                                <textarea v-model="editCourseData.description" class="form-control" rows="3"></textarea>
                                <div class="form-text">Бос қалдыруға болады</div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                            <button type="submit" class="btn btn-primary">
                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-else><i class="fas fa-check-circle"></i></span> Курсты өзгерту
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import * as courseService from '../services/course_service';
import { Toast, Modal } from 'bootstrap'

export default {
    name: "CoursesList",
    data() {
        return {
            coursesList: [],
            inActiveCoursesList: [],
            newCourse: {
                name: '',
                description: ''
            },
            editCourseData: {},
            errors: {},
            loading: false,
            createCourseModal: null,
            editCourseModal: null
        }
    },
    mounted() {
        this.createCourseModal = new Modal(this.$refs.createCourseModal)
        this.editCourseModal = new Modal(this.$refs.editCourseModal)
        this.loadCourses()
    },
    methods: {
        loadCourses: async function() {
            try {
                const response = await courseService.loadCourses();
                this.coursesList = response.data;
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
        },
        createCourse: async function() {
            this.loading = true
            let formData = new FormData()
            formData.append('name', this.newCourse.name)
            formData.append('description', this.newCourse.description)

            try {
                const response = await courseService.createCourse(formData)
                this.coursesList.unshift(response.data)
                this.errors = {}
                this.createCourseModal.hide()
                this.$toast.success('Жасалынған өзгерістер орындалды');
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    default:
                        this.$toast.error('Ощибка с сервером');
                        break;
                }
            }
            this.loading = false;
        },
        deleteCourse: async function(course) {
            if (!window.confirm(`Сіз шынында да "${course.name}" курсын өшіргіңіз келеді ме?`)) {
                return;
            }
            try {
                await courseService.deleteCourse(course.id);
                this.coursesList = this.coursesList.filter(obj => {
                    return obj.id != course.id;
                });
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
        },
        editCourse(course) {
            this.editCourseData = {...course}
            this.editCourseModal.show()
        },
        updateCourse: async function() {
            this.loading = true;
            try {
                const formData = new FormData();
                formData.append('name', this.editCourseData.name)
                formData.append('description', this.editCourseData.description)
                formData.append('_method', 'put')

                const response = await courseService.updateCourse(this.editCourseData.id, formData)
                this.coursesList.map(course => {
                    if (course.id == response.data.id) {
                        for (let key in response.data) {
                            course[key] = response.data[key]
                        }
                    }
                })
                this.errors = {}
                this.editCourseModal.hide()
                this.$toast.success('Жасалынған өзгерістер орындалды');
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
            this.loading = false
        }
    }
}
</script>

<style scoped>

</style>
