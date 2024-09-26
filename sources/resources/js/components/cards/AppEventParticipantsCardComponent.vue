<script>
import Card from "primevue/card";

export default {
    components: {
        Card
    },
    props: {
        participantsProps: Array
    }
}
</script>

<template>
    <div class="mt-3">
        <Card>
            <template #header>
                <h4 class="text-center">СПИСКИ</h4>
            </template>
            <template #content>
                <section>
                    <section v-for="participant in this.participantsProps"
                             :key="participant.id"
                             class="option-list">
                        <div class="mb-3">
                            <strong>
                                <a href="#">{{ participant.first_name }} {{ participant.last_name }}</a><br>
                            </strong>
                        </div>
                    </section>
                </section>
            </template>
        </Card>
    </div>
</template>
