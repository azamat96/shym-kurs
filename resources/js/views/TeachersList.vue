<template>
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mt-4">Мұғалімдер тізімі</h1>
            <router-link to="/teacher/create" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Жаңа мұғалім қосу
            </router-link>
        </div>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Басты бет</a></li>
            <li class="breadcrumb-item active">Мұғалімдер тізімі</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-search"></i> Фильтрлар
            </div>
            <div class="card-body">
                <div v-if="loading.filter" class="d-flex justify-content-center">
                    <div class="spinner-border text-primary m-5" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <template v-else>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="form-label">Мектебі</label>
                        <Multiselect
                            v-model="filter.schools"
                            :options="schoolsList"
                            :searchable="false"
                            track-by="name" label="name"
                            placeholder="Мектепті таңдаңыз"
                            :show-labels="false"
                            :allow-empty="true"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            selectLabel="" selectedLabel="">
                        </Multiselect>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Пәні</label>
                        <Multiselect
                            v-model="filter.subjects"
                            :options="subjectsList"
                            :searchable="false"
                            track-by="name" label="name"
                            placeholder="Пәнін таңдаңыз"
                            :show-labels="false"
                            :allow-empty="true"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            selectLabel="" selectedLabel="">
                        </Multiselect>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Курсын таңдаңыз</label>
                        <Multiselect
                            v-model="filter.courses"
                            :options="[]"
                            :searchable="false"
                            track-by="name" label="name"
                            placeholder="Курсын таңдаңыз"
                            :show-labels="false"
                            :allow-empty="true"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            selectLabel="" selectedLabel="">
                        </Multiselect>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Тілін таңдаңыз</label>
                        <Multiselect
                            v-model="filter.langs"
                            :options="langsList"
                            :searchable="false"
                            track-by="name" label="display_name"
                            placeholder="Тілін таңдаңыз"
                            :show-labels="false"
                            :allow-empty="true"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            selectLabel="" selectedLabel="">
                        </Multiselect>
                    </div>
                </div>
                <div class="row mt-2 mb-1">
                    <div class="col-lg-6">
                        <label class="form-label">Аты-жөнін енгізіңіз</label>
                        <input v-model="filter.name" type="text" class="form-control" placeholder="Мыс: Айнұр Асанова">
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Мансабы</label>
                        <Multiselect
                            v-model="filter.positions"
                            :options="positionsList"
                            :searchable="false"
                            track-by="name" label="display_name"
                            placeholder="Мансабын таңдаңыз"
                            :show-labels="false"
                            :allow-empty="true"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            selectLabel="" selectedLabel="">
                        </Multiselect>
                    </div>
                    <div class="col-lg-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" style="height: 43px">
                            <i class="fas fa-search"></i> Іздеу/Пойск
                        </button>
                    </div>
                </div>
                </template>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Мұғалімдер тізімі
            </div>
            <div class="card-body">
                <div v-if="loading.list" class="d-flex justify-content-center">
                    <div class="spinner-border text-primary m-5" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <table v-else id="datatablesSimple" class="table table-bordered">
                    <caption>Тізімде {{pagination.total}} мұғалімнің {{teachersList.length}} көрсетілінді</caption>
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Мектебі</th>
                        <th>Аты-жөні</th>
                        <th>Пәні</th>
                        <th>Туған күні</th>
                        <th>Оқыту тілі</th>
                        <th><i class="fas fa-cog"></i> Қызмет түрлері</th>
                    </tr>
                    </thead>
                    <tfoot v-if="teachersList.length > 9">
                        <tr>
                            <th>#</th>
                            <th>Мектебі</th>
                            <th>Аты-жөні</th>
                            <th>Пәні</th>
                            <th>Туған күні</th>
                            <th>Оқыту тілі</th>
                            <th><i class="fas fa-cog"></i> Қызмет түрлері</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <tr v-for="(teacher, index) in teachersList" :key="teacher.id">
                        <td>{{pagination.limit*(pagination.page-1)+index+1}}</td>
                        <td>{{teacher.school.name}}</td>
                        <td>{{teacher.name}}</td>
                        <td>{{teacher.subject.name}}</td>
                        <td>{{teacher.birth_date}}</td>
                        <td>{{langsList.find((lang) => teacher.lang === lang.name).display_name }}</td>
                        <td>
                            <button @click="" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ашып көру"><i class="fas fa-eye"></i></button>
                            <button @click="" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өзгерту"><i class="fas fa-pencil-alt"></i></button>
                            <button @click="" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өшіру"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <nav v-if="teachersList.length > 0" aria-label="Page navigation example">
                    <ul class="pagination justify-content-start pagination-sm">
                        <li :class="['page-item', {'disabled': pagination.page === 1}]">
                            <a @click.prevent="searchTeachers(pagination.page-1)" class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <span aria-hidden="true">&laquo;</span> Артқа
                            </a>
                        </li>
                        <li v-for="page in pagination.last_page" :class="['page-item', {'active': page === pagination.page}]" :key="page">
                            <a class="page-link" href="#" @click.prevent="searchTeachers(page)">{{page}}</a>
                        </li>
                        <li :class="['page-item', {'disabled': pagination.page === pagination.last_page}]">
                            <a @click.prevent="searchTeachers(pagination.page+1)" class="page-link" href="#">
                                Алға <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import * as teacherService from '../services/teacher_service'
import {mapState,mapActions} from 'vuex'

export default {
    name: "TeachersList",
    components: {Multiselect},
    data() {
        return {
            teachersList: [],
            pagination: {
                limit: 15,
                page: 1,
                total: null,
                last_page: null
            },
            loading: {
                list: true,
                filter: true,
            },
            filter: {
                name: "",
                schools: [],
                subjects: [],
                langs: [],
                courses: [],
                positions: []
            },


        }
    },
    computed: {
        ...mapState({
            schoolsList: 'schools',
            subjectsList: 'subjects',
            langsList: 'langs',
            positionsList: 'positions',
        }),
    },
    mounted() {
        // this.filter.positions.push(this.positionsList[0])
        this.loading.filter = true
        Promise.all([this.loadAllSchools(), this.loadAllSubjects()]).then(() => {
            this.loading.filter = false
        }, () => {
            this.$toast.error('Серверде қателіктері');
        })
        this.searchTeachers()
    },
    methods: {
        ...mapActions({
            loadAllSchools: 'loadAllSchools',
            loadAllSubjects: 'loadAllSubjects',
        }),
        searchTeachers: async function(page = 1) {
            this.loading.list = true
            this.pagination.page = page
            try {
                let params = {
                    limit: this.limit,
                    page: this.page,
                }
                const response = await teacherService.searchTeachers(params)
                this.pagination.total = response.data.total
                this.pagination.last_page = response.data.last_page
                this.teachersList = response.data.data

                console.log(response, 'teachersList')
            } catch (e) {
                this.$toast.error('Серверде қателіктер');
            }
            this.loading.list = false;
        }
    }
}
</script>

<style lang="scss" scoped>
$multiselect-length: 43px;

.form-control {
    height: $multiselect-length;
}
</style>
