<template>
    <div class="container-fluid px-4">
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
                                <span v-if="!isModeCreate" class="badge rounded-pill bg-success ml-3">Жұмыс істейді</span>
                            </div>
                        </div>
                        <hr size="1" class="hr-line">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Аты-жөні</label>
                                    <input v-model="name" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Туылған күні</label>
                                    <input v-model="birthDate" type="date" class="form-control" placeholder="24.12.1996">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Телефон</label>
                                    <input v-model="phone" type="text" class="form-control" placeholder="">
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
                                        selectLabel="" selectedLabel="">
                                    </Multiselect>
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
                                        selectLabel="" selectedLabel="">
                                    </Multiselect>
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
                                        selectLabel="" selectedLabel="">
                                    </Multiselect>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Пед-қ еңбек өтілі/стажы</label>
                                    <input v-model="stazh" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Пәнге қатысты басқа да курстан өтуі</label>
                                    <textarea v-model="additionalInfo" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <template v-if="!isModeShow">
                            <button @click="saveTeacher()" type="button" class="btn btn-primary">
                                <span v-if="loading.update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-else><i class="fas fa-check-circle"></i></span> Сақтау
                            </button>
                            <button type="button" class="btn btn-secondary">Артқа қайту</button>
                        </template>
                        <hr class="hr-line" size="1">
                        Курстар тізімі
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import * as teacherService from '../services/teacher_service'

export default {
    name: "AddTeacher",
    components: {Multiselect},
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
            isActive: false,
            langsList: [
                {
                    display_name: 'қазақ тілінде',
                    name: 'kk'
                },
                {
                    display_name: 'орыс тілінде',
                    name: 'ru'
                },
                {
                    display_name: 'қазақ/орыс тілдерінде',
                    name: 'kk_ru'
                },
            ],
            schoolsList: [],
            subjectsList: []
        }
    },
    computed: {
        isModeCreate() { return this.mode === "create" },
        isModeUpdate() { return this.mode === "update" },
        isModeShow() { return this.mode === "show" },
        currentTeacherID() { return this.$route.params.id }
    },
    mounted() {
        this.loading.page = true;
        Promise.all([this.loadListOfSchools(), this.loadListOfSubjects()]).then(() => {
            this.getTeacher().then(() => {
                this.loading.page = false;
            });
        })
    },
    methods: {
        loadListOfSchools: async function() {
            try {
                const response = await teacherService.loadSchools();
                console.log('0')
                this.schoolsList = response.data
            } catch (error) {
                this.$toast.error('Серверде қателіктері');
            }
        },
        loadListOfSubjects: async function() {
            try {
                const response = await teacherService.loadSubjects();
                console.log('2')
                this.subjectsList = response.data
            } catch (error) {
                this.$toast.error('Серверде қателіктері');
            }
        },
        saveTeacher: async function() {
            // TODO Frontend validation
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
            }
            try {
                if (this.isModeCreate) {
                    const response = await teacherService.createTeacher(query);
                    console.log(response)
                    this.$toast.success('Жаңа мұғалім қосылды');
                }
                if (this.isModeUpdate) {
                    query._method = 'put'
                    const response = await teacherService.updateTeacher(this.currentTeacherID, query);
                    console.log(response)
                    this.$toast.success('Мұғалімнің ақпараттары өзгерді');
                }
            } catch (error) {
                this.$toast.error('Серверде қателіктер');
            }
            this.loading.update = false;
        },
        getTeacher: async function() {
            if (this.isModeCreate) {
                return;
            }
            try {
                const response = await teacherService.getTeacher(this.currentTeacherID);
                console.log(response.data)
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

            } catch (error) {
                this.$toast.error('Серверде қателіктер');
            }
        }
    }
}
</script>

<style>
@import "~vue-multiselect/dist/vue-multiselect.min.css";

.multiselect__tags {
    border: 1px solid #ced4da;
}
</style>
