var appdocente = new Vue({
    el: '#frmDocentes',
    data: {
        docente: {
            id_docente: 0,
            accion: 'nuevo',
            codigo: '',
            nombre: '',
            direccion: '',
            dui: '',
            telefono: '',
            msg: ''
        }
    },
    methods: {
        guardarDocente: function () {
            fetch(`private/modulos/docentes/procesos.php?proceso=recibirDatos&docente=${JSON.stringify(this.docente)}`).then(resp => resp.json()).then(resp => {
                this.docente.msg = resp.msg;
                this.docente.id_docente = 0;
                this.docente.codigo = '';
                this.docente.nombre = '';
                this.docente.direccion = '';
                this.docente.telefono = '';
                this.docente.dui = '';
                this.docente.accion = 'nuevo';
                appBuscarDocentes.buscarDocente();
            });
        }
    }
});