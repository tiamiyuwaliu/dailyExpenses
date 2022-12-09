import {Inertia} from "@inertiajs/inertia";

export const url = {
    methods : {
        goTo(link) {
            Inertia.visit(link)
        }
    }
}