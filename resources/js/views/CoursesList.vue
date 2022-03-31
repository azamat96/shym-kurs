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
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#active-courses" type="button" role="tab" aria-controls="home" aria-selected="true">
                            Активный курстар
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#archive-courses" type="button" role="tab" aria-controls="profile" aria-selected="false">
                            Архивный курстар
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="active-courses" role="tabpanel" aria-labelledby="home-tab">
                        <ActiveCourses></ActiveCourses>
                    </div>
                    <div class="tab-pane fade" id="archive-courses" role="tabpanel" aria-labelledby="profile-tab">
                        <ArchiveCourses></ArchiveCourses>
                    </div>
                </div>
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
    </div>
</template>

<script>
import * as courseService from '../services/course_service';
import { Modal } from 'bootstrap'
import ActiveCourses from "../components/ActiveCourses";
import ArchiveCourses from "../components/ArchiveCourses";

export default {
    name: "CoursesList",
    components: {ActiveCourses, ArchiveCourses},
    data() {
        return {
            newCourse: {
                name: '',
                description: ''
            },
            errors: {},
            loading: false,
            createCourseModal: null,
        }
    },
    mounted() {
        this.createCourseModal = new Modal(this.$refs.createCourseModal)
    },
    methods: {
        createCourse: async function() {
            this.loading = true
            let formData = new FormData()
            formData.append('name', this.newCourse.name)
            formData.append('description', this.newCourse.description)

            try {
                const response = await this.$store.dispatch('createCourse', formData)
                this.$store.commit('CREATE_COURSE', response.data)
                this.errors = {}
                this.createCourseModal.hide()
                this.$toast.success(`Жаңа "${response.data.name}" курсы қосылды`);
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    default:
                        this.$toast.error('Серверде қателіктері');
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
