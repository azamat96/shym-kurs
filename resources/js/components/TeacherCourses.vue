<template>
    <div>
        <hr class="hr-line" size="1">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Курстарының тізімі</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attachCourseModal">
                <i class="fas fa-graduation-cap"></i> Курс оқуға жіберу
            </button>
        </div>
        <ol v-if="currentTeacher.hasOwnProperty('courses') && currentTeacher.courses.length > 0"
            class="list-group list-group-numbered mt-3">
            <li v-for="course in currentTeacher.courses" :key="course.pivot.pivot_id" class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ course.name }}</div>
                    {{ course.pivot.done_date | getYear }}
                </div>
                <button @click="detachCourse(course)" class="btn btn-primary align-self-center btn-sm">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </li>
        </ol>
        <span v-else>Курстары жоқ</span>
        <!-- Modal for create course -->
        <div class="modal fade" id="attachCourseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="attachCourseModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="flex-fill modal-title text-center" id="exampleModalLabel">Курсқа жіберу</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Курсты таңдаңыз</label>
                            <Multiselect
                                v-model="course"
                                :options="coursesList"
                                :searchable="false"
                                track-by="name" label="name"
                                placeholder="Курсты таңдаңыз"
                                :show-labels="false"
                                :allow-empty="false"
                                :class="{'is-multiselect-invalid': errors && !course}">
                            </Multiselect>
                            <div v-if="errors && !course" class="invalid-feedback" style="display: block">
                                Бір курсты таңдауыңыз қажет
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                        <button @click="attachCourse()" type="button" class="btn btn-primary">
                            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span v-else><i class="fas fa-check-circle"></i></span> Курсты оқуға жіберу
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import {mapState} from 'vuex'
import {Modal} from "bootstrap";
import * as teacherService from "../services/teacher_service";

export default {
    name: "TeacherCourses",
    components: {Multiselect},
    computed: {
        currentTeacherID() { return this.$route.params.id },
        ...mapState({
            coursesList: 'activeCourses',
            currentTeacher: 'currentTeacher'
        })
    },
    data() {
        return {
            loading: false,
            course: null,
            modal: null,
            errors: false,
        }
    },
    mounted() {
        this.modal = new Modal(this.$refs.attachCourseModal)
        this.loadCourses()
    },
    methods: {
        loadCourses: async function () {
            this.loading = true
            try {
                const response = await this.$store.dispatch('getActiveCourses');
                this.$store.commit('SET_ACTIVE_COURSES', response.data)
            } catch (error) {
                this.$toast.error('Ощибка с сервером');
            }
            this.loading = false
        },
        attachCourse: async function() {
            this.loading = true
            if (!this.course) {
                this.errors = true
                this.loading = false
                return;
            }
            try {
                const response = await teacherService.attachCourse(this.currentTeacherID, this.course.id);
                this.$store.commit('ATTACH_COURSE_TO_CURRENT_TEACHER', response.data)
                this.modal.hide()
                this.$toast.success(`"${this.course.name}" курсына жіберілді`);
                this.course = null
                console.log(response,'attachCourse')
            } catch (error) {
                this.$toast.error('Cерверде қателіктер');
            }
            this.loading = false
        },
        detachCourse: async function(course) {
            let doneDate = new Date(course.pivot.done_date)
            if (!window.confirm(`Сіз шынында да "${course.name}-${doneDate.getFullYear()}" курсын бұл кісіден алып тастағыңыз келеді ме?`)) {
                return;
            }
            try {
                await teacherService.detachCourse(this.currentTeacherID, course.id, {pivot_id: course.pivot.pivot_id});
                this.$store.commit('DETACH_COURSE_FROM_CURRENT_TEACHER', course.pivot.pivot_id)
                this.$toast.success(`"${course.name}-${doneDate.getFullYear()}" курсы өшірілді`);
            } catch (error) {
                this.$toast.error('Серверде қателіктер');
            }
        }
    }
}
</script>

<style scoped>

</style>
