<template>
    <div class="container-fluid px-2 px-md-4">
        <h1 class="mt-4">Мұғалім қосу/өшіру</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Басты бет</a></li>
            <li class="breadcrumb-item active">Мұғалім қосу/өшіру</li>
        </ol>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card mb-4 ">
                    <div v-if="loading.page" class="d-flex justify-content-center">
                        <div class="spinner-border text-primary m-5" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div v-else class="card-body pt-4 pb-4 pl-4 pr-4">
                        <div class="d-flex align-items-center justify-content-start">
                            <i class="fas fa-user-circle mr-3" style="font-size: 70px"></i>
                            <div style="padding-left: 1rem">
                                <h3 class="mb-0">{{ name }}</h3>
                                <span v-if="!isModeCreate && isActive" class="badge rounded-pill bg-success ml-3">Жұмыс істейді</span>
                                <span v-if="!isModeCreate && !isActive" class="badge rounded-pill bg-secondary ml-3">Жұмыс істемейді</span>
                            </div>
                        </div>
                        <hr size="1" class="hr-line">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Аты-жөні</label>
                                    <input v-model="name"
                                           :class="[
                                               'form-control',
                                               {'is-invalid': validationOn && !name},
                                               {'is-valid': validationOn && name}]"
                                           type="text"
                                           placeholder=""
                                           :disabled="isModeShow">
                                    <div class="invalid-feedback">
                                        Аты-жөнін толтырыңыз
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Туылған күні</label>
                                    <input v-model="birthDate"
                                           type="date"
                                           :class="[
                                               'form-control',
                                               {'is-invalid': validationOn && !birthDate},
                                               {'is-valid': validationOn && birthDate}]"
                                           placeholder="" :disabled="isModeShow">
                                    <div class="invalid-feedback">
                                        Туылған күнін көрсетіңіз
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Телефон</label>
                                    <input v-model="phone"
                                           type="text"
                                           :class="[
                                               'form-control',
                                               {'is-invalid': validationOn && !phone},
                                               {'is-valid': validationOn && phone}]"
                                           placeholder="" :disabled="isModeShow">
                                    <div class="invalid-feedback">
                                        Телефон номерін жазыңыз
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-line" size="1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Мектебі</label>
                                    <Multiselect
                                        v-model="school"
                                        :options="schoolsList"
                                        :searchable="true"
                                        track-by="name" label="name"
                                        placeholder="Мектепті таңдаңыз"
                                        :show-labels="false"
                                        :allow-empty="false"
                                        selectLabel="" selectedLabel=""
                                        :disabled="isModeShow"
                                        :class="[{'is-multiselect-invalid': validationOn && !school},
                                               {'is-multiselect-valid': validationOn && school}]">
                                    </Multiselect>
                                    <div v-if="validationOn && !school" class="invalid-feedback" style="display: block">
                                        Мектебін таңдаңыз
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Сабақ жүргізетін пәні</label>
                                    <Multiselect
                                        v-model="subject"
                                        :options="subjectsList"
                                        :searchable="true"
                                        track-by="name" label="name"
                                        placeholder="Пәнді таңдаңыз"
                                        :show-labels="false"
                                        :allow-empty="false"
                                        selectLabel="" selectedLabel=""
                                        :disabled="isModeShow"
                                        :class="[{'is-multiselect-invalid': validationOn && !subject},
                                               {'is-multiselect-valid': validationOn && subject}]">
                                    </Multiselect>
                                    <div v-if="validationOn && !subject" class="invalid-feedback" style="display: block">
                                        Сабақ жүргізетін пәнін таңдаңыз
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Оқыту тілі</label>
                                    <Multiselect
                                        v-model="lang"
                                        :options="langsList"
                                        :searchable="false"
                                        track-by="name" label="display_name"
                                        placeholder="Оқыту тілін таңдаңыз"
                                        :show-labels="false"
                                        :allow-empty="false"
                                        selectLabel="" selectedLabel=""
                                        :disabled="isModeShow"
                                        :class="[{'is-multiselect-invalid': validationOn && !lang},
                                               {'is-multiselect-valid': validationOn && lang}]">
                                    </Multiselect>
                                    <div v-if="validationOn && !lang" class="invalid-feedback" style="display: block">
                                        Оқыту тілін таңдаңыз
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Пед-қ еңбек өтілі/стажы</label>
                                    <input v-model="stazh"
                                           type="text"
                                           :class="[
                                               'form-control',
                                               {'is-invalid': validationOn && !stazh},
                                               {'is-valid': validationOn && stazh}]"
                                           placeholder="" :disabled="isModeShow">
                                    <div class="invalid-feedback">
                                        Пед-қ еңбек өтілін жазыңыз
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Пәнге қатысты басқа да курстан өтуі</label>
                                    <textarea v-model="additionalInfo" class="form-control" rows="3" :disabled="isModeShow"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Мансабы</label>
                                    <Multiselect
                                        v-model="position"
                                        :options="positionsList"
                                        :searchable="false"
                                        track-by="name" label="display_name"
                                        placeholder="Мансабын таңдаңыз"
                                        :show-labels="false"
                                        :allow-empty="false"
                                        selectLabel="" selectedLabel=""
                                        :disabled="isModeShow"
                                        :class="[{'is-multiselect-invalid': validationOn && !position},
                                               {'is-multiselect-valid': validationOn && position}]">
                                    </Multiselect>
                                    <div v-if="validationOn && !position" class="invalid-feedback" style="display: block">
                                        Мансабын таңдаңыз
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template v-if="!isModeShow">
                            <button @click="saveTeacher()" :disabled="loading.update" type="button" class="btn btn-primary">
                                <span v-if="loading.update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-else><i class="fas fa-check-circle"></i></span> Сақтау
                            </button>
                            <router-link to="/home/teacher/list">
                                <button type="button" class="btn btn-secondary">Тізімге қайта оралу</button>
                            </router-link>
                        </template>

                        <TeacherCourses v-if="!isModeCreate"></TeacherCourses>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import * as teacherService from '../services/teacher_service'
import TeacherCourses from "../components/TeacherCourses";
import {mapState, mapActions} from 'vuex'

export default {
    name: "AddTeacher",
    components: {Multiselect, TeacherCourses},
    props: {
        mode: {
            type: String,
            default: () => 'create' // modes = ['create','show','update']
        }
    },
    data () {
        return {
            loading: {
                page: false,
                update: false
            },
            name: null,
            birthDate: null,
            phone: null,
            school: null,
            subject: null,
            lang: null,
            stazh: null,
            additionalInfo: null,
            isActive: true,
            position: null,
            validationOn: false,
        }
    },
    computed: {
        isModeCreate() { return this.mode === "create" },
        isModeUpdate() { return this.mode === "update" },
        isModeShow() { return this.mode === "show" },
        currentTeacherID() { return this.$route.params.id },
        ...mapState({
            schoolsList: 'schools',
            subjectsList: 'subjects',
            langsList: 'langs',
            positionsList: 'positions'
        }),
    },
    mounted() {
        this.loading.page = true;
        Promise.all([this.loadListOfSchools(), this.loadListOfSubjects()]).then(() => {
            this.getTeacher();
        }, () => {
            this.$toast.error('Серверде қателіктері');
        })
        this.setInputsByDefault()
    },
    watch: {
        // Для смены ровтов где роуты reusable(route change calls same component)
        $route(to, from) {
            // react to route changes...
            if (to.name === "update_teacher") {
                console.log('route updated', to, from)
                this.mode = "update"
                this.getTeacher();
            }
            if (to.name === "create_teacher") {
                console.log('route created', to, from)
                this.mode = "create"
                this.setInputsByDefault()
            }
        }
    },
    methods: {
        setInputsByDefault() {
            if (this.isModeCreate) {
                this.name = null
                this.phone = null
                this.additionalInfo = null
                this.birthDate = null
                this.school = null
                this.subject = null
                this.isActive = true
                this.lang = null
                this.stazh = null
                this.position = this.positionsList[0]
            }
        },
        ...mapActions({
            loadListOfSchools: 'loadAllSchools',
            loadListOfSubjects: 'loadAllSubjects',
        }),
        saveTeacher: async function() {
            if (!this.validation()) {
                this.validationOn = true
                return;
            }
            this.loading.update = true;
            const query = {
                name: this.name,
                birth_date: this.birthDate,
                phone: this.phone,
                lang: this.lang.name,
                stazh: this.stazh,
                additional_info: this.additionalInfo,
                school_id: this.school.id,
                subject_id: this.subject.id,
                is_active: this.isActive,
                position: this.position.name,
            }
            try {
                if (this.isModeCreate) {
                    const response = await teacherService.createTeacher(query);
                    console.log(response, 'created')
                    this.$toast.success('Жаңа мұғалім қосылды');
                    this.validationOn = false
                    this.$router.push(`/teacher/update/${response.data.id}`)
                }
                if (this.isModeUpdate) {
                    query._method = 'put'
                    const response = await teacherService.updateTeacher(this.currentTeacherID, query);
                    console.log(response, 'updated')
                    this.$toast.success('Мұғалімнің ақпараттары өзгерді');
                    this.validationOn = false
                }
            } catch (error) {
                this.$toast.error('Серверде қателіктер');
            }
            this.loading.update = false;
        },
        getTeacher: async function() {
            if (this.isModeCreate) {
                this.loading.page = false;
                return;
            }
            this.loading.page = true;
            try {
                const response = await this.$store.dispatch('getTeacher', this.currentTeacherID);
                this.$store.commit('SET_CURRENT_TEACHER', response.data)
                console.log(response.data, 'getTeacher1')
                this.name = response.data.name
                this.phone = response.data.phone
                this.additionalInfo = response.data.additional_info
                this.birthDate = response.data.birth_date
                this.isActive = response.data.is_active
                this.lang = response.data.lang
                this.stazh = response.data.stazh
                this.school = this.schoolsList.find(x => x.id === response.data.school_id)
                this.subject = this.subjectsList.find(x => x.id === response.data.subject_id)
                this.lang = this.langsList.find(x => x.name === response.data.lang)
                this.position = this.positionsList.find(x => x.name === response.data.position)
            } catch (error) {
                this.$toast.error('Серверде қателіктер');
            }
            this.loading.page = false;
        },
        validation() {
            return this.name
                && this.birthDate
                && this.phone
                && this.school
                && this.subject
                && this.lang
                && this.stazh
                && this.position;
        }
    }
}
</script>

<style>

.multiselect__tags {
    border: 1px solid #ced4da;
}
</style>
