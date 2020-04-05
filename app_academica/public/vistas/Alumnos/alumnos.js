var appalumno = new Vue({
    el: '#frm-alumnos',
    data: {
        alumno: {
            idAlumno: 0,
            accion: 'nuevo',
            codigo: '',
            nombre: '',
            direccion: '',
            telefono: '',
            msg: ''
        }
    },
    methods: {
        guardarAlumno: function () {
            fetch(`private/modulos/alumnos/procesos.php?proceso=recibirDatos&alumno=${JSON.stringify(this.alumno)}`).then(resp => resp.json()).then(resp => {
                this.alumno.msg = resp.msg;
                this.limpiarAlumno()
                appBuscarAlumnos.buscarAlumno();
            });
        },
        limpiarAlumno: function(){
            this.alumno.idAlumno = 0;
            this.alumno.codigo = '';
            this.alumno.nombre = '';
            this.alumno.direccion = '';
            this.alumno.telefono = '';
            this.alumno.accion = 'nuevo';
        }
    }
});