<template>
    <CardEditor
        v-model="title"
        @closed="closed"
        @saved="addCard"
        label="Add card"
    ></CardEditor>
</template>

<script>
import CardAdd from './../graphql/CardAdd.gql';
import { EVENT_CARD_ADDED } from './../constants';
import CardEditor from './CardEditor';

export default {
    components: {
        CardEditor
    },
    props: {
        list: Object
    },
    data() {
        return {
            title: null,
        };
    },
    mounted() {
        this.$refs.card.focus();
    },
    methods: {
        addCard() {
            const self = this;
            this.$apollo.mutate({
                mutation: CardAdd,
                variables: {
                    title: this.title,
                    listId: this.list.id,
                    order: this.list.cards.length + 1
                },
                update: (store, { data: { cardAdd } }) => {
                    self.$emit('added', {
                        store,
                        data: cardAdd,
                        type: EVENT_CARD_ADDED
                    });
                    self.close();
                }
            });
        },
        closed() {
            this.$emit('close-editor');
        }
    },
}
</script>
