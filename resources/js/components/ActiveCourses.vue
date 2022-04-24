<template>
    <div>
        <div v-if="loading.page" class="d-flex justify-content-center">
            <div class="spinner-border text-primary m-5" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else class="table-responsive">
        <table class="table table-bordered mb-0">
            <caption>{{ coursesList.length > 0 ? 'Тізімде бүкіл активты курстар': 'Активты курстар жоқ'}}</caption>
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Курс атауы</th>
                <th>Толық ақпарат</th>
                <th><i class="fas fa-cog"></i> Қызмет түрлері</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(course, index) in coursesList" :key="course.id">
                <td>{{ index+1 }}</td>
                <td>{{ course.name }}</td>
                <td>{{ course.description }}</td>
                <td>
                    <button v-on:click="editCourse(course)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өзгерту"><i class="fas fa-pencil-alt"></i></button>
                    <button v-on:click="archiveCourse(course, index)" class="btn btn-secondary btn-sm">
                        <span v-if="loading.archive === index" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span v-else><i class="fas fa-power-off"></i></span> Архивтау
                    </button>
                    <button v-on:click="deleteCourse(course)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өшіру"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
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
                                <label class="form-label">Курс атауы</label>
                                <input v-model="editCourseData.name" v-bind:class="{'is-invalid': errors.name}" type="text" class="form-control" aria-describedby="emailHelp" required>
                                <div class="invalid-feedback" v-if="errors.name" v-bind:class="{'d-block': errors.name}">{{ errors.name[0] }}</div>
                                <div class="form-text" v-else>Басқа курс атаумен бірдей болмағаны жөн</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Толық ақпарат</label>
                                <textarea v-model="editCourseData.description" class="form-control" rows="3"></textarea>
                                <div class="form-text">Бос қалдыруға болады</div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                            <button type="submit" class="btn btn-primary">
                                <span v-if="loading.update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
import {Modal} from "bootstrap";
import {mapState} from 'vuex'

export default {
    name: "ActiveCourses",
    data() {
        return {
            editCourseData: {},
            errors: {},
            loading: {
                page: false,
                update: false,
                archive: null
            },
            editCourseModal: null
        }
    },
    computed: mapState({
        coursesList: 'activeCourses',
    }),
    mounted() {
        this.editCourseModal = new Modal(this.$refs.editCourseModal)
        this.loadCourses()
    },
    methods: {
        loadCourses: async function () {
            this.loading.page = true
            try {
                await this.$store.dispatch('getActiveCourses');
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
            this.loading.page = false
        },
        deleteCourse: async function(course) {
            if (!window.confirm(`Сіз шынында да "${course.name}" курсын өшіргіңіз келеді ме?`)) {
                return;
            }
            try {
                await this.$store.dispatch('deleteCourse', course.id);
                this.$store.commit('DELETE_ACTIVE_COURSE', course.id)
                this.$toast.success(`"${course.name}" курсы өшірілді`);
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
        },
        editCourse(course) {
            this.editCourseData = {...course}
            this.editCourseModal.show()
        },
        updateCourse: async function() {
            this.loading.update = true;
            try {
                let query = {
                    name: this.editCourseData.name,
                    description: this.editCourseData.description,
                    _method: 'put'
                }
                const response = await this.$store.dispatch('updateCourse', {id: this.editCourseData.id, options: query})
                this.$store.commit('UPDATE_ACTIVE_COURSE', response.data)
                this.errors = {}
                this.editCourseModal.hide()
                this.$toast.success('Жасалынған өзгерістер орындалды');
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
            this.loading.update = false
        },
        archiveCourse: async function(course, index) {
            if (!window.confirm(`Сіз "${course.name}" курсын архивтағыңыз келеді ме?`)) {
                return;
            }
            this.loading.archive = index;
            try {
                let query = {
                    is_active: 0,
                    _method: 'put'
                }
                const response = await this.$store.dispatch('updateCourse', {id: course.id, options: query})
                this.$store.commit('ARCHIVE_COURSE', response.data)
                this.$toast.success(`Курс "${response.data.name}" архивқа жіберілінді`);
            } catch (error) {
                this.$toast.error('Серверде қателіктер');
            }
            this.loading.archive = false
        }
    }
}
</script>

<style scoped>

</style>
