<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'text'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ '...'+valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'"><img :src="'/storage/'+valor" width="30" height="30"></span>
                    </td>
                </tr>
                
                
                <!-- <tr v-for="obj in dados" :key="obj.id">
                    <td v-if="titulos.includes(chave)" v-for="valor, chave in obj" :key="chave">
                        <span v-if="chave == 'imagem'">
                            <img :src="'/storage/'+valor" width="30" height="30">
                        </span>
                        <span v-else>
                            {{ valor }}
                        </span>
                    </td> -->
                    
                    <!--
                    <th scope="row">{{m.id}}</th>
                    <td>{{m.nome}}</td>
                    <td><img :src="'/storage/'+m.imagem" width="30" height="30"></td>
                    
                </tr>-->
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos'],
        computed: {
            dadosFiltrados() {
                
                let campos = Object.keys(this.titulos)
                let dadosFiltrados = []
                
                this.dados.map((item, chave) => {
                    let itemFiltrado = {}
                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo]
                    })
                    
                dadosFiltrados.push(itemFiltrado)
               
                })
                return dadosFiltrados
            }
        }
    }
</script>








<!-- <template>
<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key ="key">{{ t }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="m in dados" :key="m.id">
                <th scope="row">{{m.id}}</th>
                <td>{{m.nome}}</td>
                <td><img :src="'/storage/'+m.imagem" alt="" width="30" height="30"></td> 
            </tr>
    
        </tbody>
    </table>
</div>
</template>

<script>
    export default {
        props: ['dados', 'titulos']
    }
</script> -->
