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
                    <div class="card-body pt-4 pb-4 pl-4 pr-4">
                        <div class="d-flex align-items-center justify-content-start">
                            <i class="fas fa-user-circle mr-3" style="font-size: 70px"></i>
                            <div style="padding-left: 1rem">
                                <h3 class="mb-0">Asan Majit</h3>
                                <span class="badge rounded-pill bg-success ml-3">Жұмыс істейді</span>
                            </div>
                        </div>
                        <hr size="1" class="hr-line">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Аты-жөні</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Туылған күні</label>
                                    <input type="date" class="form-control" placeholder="24.12.1996">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Телефон</label>
                                    <input type="text" class="form-control" placeholder="+77027775566">
                                </div>
                            </div>
                        </div>
                        <hr class="hr-line" size="1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Мектебі</label>
                                    <input type="text" class="form-control" placeholder="№12">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Сабақ жүргізетін пәні</label>
                                    <input type="text" class="form-control" placeholder="Алгебра">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Оқыту тілі</label>
                                    <input type="text" class="form-control" placeholder="Казак">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Пед-қ еңбек өтілі/стажы</label>
                                    <input type="text" class="form-control" placeholder="1 жыл">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Пәнге қатысты басқа да курстан өтуі</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary"><i class="fas fa-check-circle"></i> Сақтау</button>
                        <button type="button" class="btn btn-secondary">Артқа қайту</button>
                        <hr class="hr-line" size="1">
                        Курстар тізімі
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddTeacher"
}
</script>

<style scoped>

</style>
