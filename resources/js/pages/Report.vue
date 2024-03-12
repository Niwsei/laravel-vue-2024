<template>
    <div>
<h1>REport</h1>
<hr>
Token :{{ store.get_token }}
    </div>
</template>

<script>
import { useStore } from '../Store/auth';
    export default {
        setup(){
        const store = useStore();
        return { store }
        }
        
    }
</script>

<style lang="scss" scoped>

</style>