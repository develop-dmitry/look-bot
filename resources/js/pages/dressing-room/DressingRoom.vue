<template>
    <div class="dressing-room">
        <h1>Dressing Room</h1>
        <div class="dressing-room__slider">
            <div
                class="dressing-room-card dressing-room__slide"
                v-for="(item, index) in clothes"
                :key="item.id"
                :class="{
                    'dressing-room__slide_current': current === index,
                    'dressing-room__slide_prev': isPrev(index),
                    'dressing-room__slide_next': isNext(index)
                }"
                v-touch:swipe.left="prev"
                v-touch:swipe.right="next"
            >
                <div class="dressing-room-card__image">
                    <span
                        class="dressing-room__control dressing-room__control_prev"
                        v-if="!isFirst(index)"
                        @click.prevent="prev"
                    ></span>
                    <img :src="item.photo" :alt="item.name">
                    <span
                        class="dressing-room__control dressing-room__control_next"
                        v-if="!isLast(index)"
                        @click.prevent="next"
                    ></span>
                </div>
                <span class="dressing-room-card__name">
                    {{ item.name }}
                </span>
                <a
                    class="dressing-room-card__button"
                    :class="{'dressing-room-card__button_selected': item.isChosen}"
                    href="#"
                >
                    {{ (item.isChosen) ? 'Удалить' : 'Выбрать' }}
                </a>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Ajax from "../../common/ajax/Ajax";
import AjaxRequest from "../../common/ajax/AjaxRequest";
import Clothes from "../../entities/Clothes";

export default {
    name: 'DressingRoom',

    data() {
        return {
            clothes: [] as Array<Clothes>,
            current: 0 as number,
            page: 1 as number,
            perPage: 10 as number,
            loading: false as boolean,
            onLastPage: false as boolean
        }
    },

    computed: {
        nextIndex() {
            const next = this.current + 1;

            if (next < this.clothes.length) {
                return next;
            }

            return 0;
        },

        prevIndex() {
            const prev = this.current - 1;

            if (prev >= 0) {
                return prev;
            }

            return this.clothes.length - 1;
        },

        needLoading() {
            if (this.onLastPage) {
                return false;
            }

            const current = this.current + 1;

            const total = this.page * this.perPage;

            if (total - current > this.perPage) {
                return false;
            }

            return ((total - this.current) / this.perPage) * 100 <= 30;
        }
    },

    methods: {
        next() {
            if (this.isLast(this.current)) {
                return;
            }

            this.current = this.nextIndex;
        },

        prev() {
            if (this.isFirst(this.current)) {
                return;
            }

            this.current = this.prevIndex;
        },

        isNext(index) {
            return index === this.nextIndex;
        },

        isPrev(index) {
            return index === this.prevIndex;
        },

        isFirst(index) {
            return index === 0;
        },

        isLast(index) {
            return index === this.clothes.length - 1;
        },

        async getClothes() {
            if (this.loading) {
                return;
            }

            this.loading = true;

            const response = await Ajax.post(new AjaxRequest('/api/v1/clothes', {
                page: this.page,
                perPage: this.perPage
            }));

            if (response.success) {
                response.data.items.forEach((item: { id: number, name: string, photo: string }) => {
                    this.clothes.push(new Clothes(
                        item.id,
                        item.name,
                        item.photo,
                        item.is_chosen
                    ));
                });

                this.page = response.data.page;
                this.onLastPage = this.page === response.data.page_total;
            }

            this.loading = false;
        }
    },

    watch: {
        needLoading(value) {
            if (value) {
                this.page++;
                this.getClothes();
            }
        }
    },

    mounted() {
        this.getClothes();
    }
}
</script>

<style lang="scss" scoped>
.dressing-room {
    font-size: 16px;
    max-width: 100%;
    text-align: center;

    &__slider {
        display: inline-flex;
        justify-content: center;
        position: relative;
    }

    &__slide {
        display: none;
        transition: all .2s linear;

        &_current {
            display: block;
            position: relative;
            z-index: 2;
            opacity: 1;
            transform: translateX(0);
        }

        &_prev,
        &_next {
            opacity: 0;
            display: block;
            z-index: 1;
            position: absolute;
            left: 0;
            top: 0;
        }

        &_prev {
            transform: translateX(-100%);
        }

        &_next {
            transform: translateX(100%);
        }
    }

    &__control {
        position: absolute;
        top: 50%;
        width: 20px;
        height: 20px;
        background: #000000;
        cursor: pointer;

        &_prev {
            left: 0;
        }

        &_next {
            right: 0;
        }
    }
}

.dressing-room-card {

    &__image {
        max-width: 100%;
        height: auto;
        position: relative;
        display: inline-flex;
    }

    &__name {
        margin-top: 1rem;
        font-size: 1rem;
        line-height: 1.5;
        display: block;
    }

    &__button {
        display: block;
        width: 100%;
        background: green;
        color: #ffffff;
        text-decoration: none;
        margin-top: 1.15rem;
        padding: 15px 20px;
        font-weight: 700;
        border-radius: .5rem;
        position: relative;

        &_selected {
            &:before {
                content: '\2713';
                width: 1.5rem;
                height: 1.5rem;
                border-radius: 50%;
                border: .25rem solid #ffffff;
                position: absolute;
                left: -3px;
                top: -3px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
            }
        }
    }
}
</style>
