var appBuscarDocentes = new Vue({
    el: '#frm-buscar-docentes',
    data: {
        misdocentes: [],
        valor: ''
    },
    methods: {
        buscarDocente: function () {
            fetch(`private/modulos/docentes/procesos.php?proceso=buscarDocente&docente=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.misdocentes = resp;
            });
        },
        modificarDocente: function (docente) {
            appdocente.docente = docente;
            appdocente.docente.accion = 'modificar';
        },
        eliminarDocente: function (id_docente) {
            let dialog = document.getElementById("dialogDocentes");
            dialog.close();
            dialog.showModal();


            $(`#btnCancelarDocentes`).click(e=>{
                dialog.close();
            })

            $(`#btnConfirmarDocentes`).click(e=>{
                fetch(`private/modulos/docentes/procesos.php?proceso=eliminarDocente&docente=${id_docente}`).then(resp => resp.json()).then(resp => {
                    this.buscarDocente();
                });
                dialog.close();
            })
            
        }
    },
    created: function () {
        this.buscarDocente();
    }
});