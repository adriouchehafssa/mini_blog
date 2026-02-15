<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Modal } from '@inertiaui/modal-vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { ref } from 'vue';

interface Post {
    id: number;
    title: string;
    content: string;
    category: string;
    lieu: string;
    status: string;
}

const props = defineProps<{
    post: Post;
}>();

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    category: props.post.category,
    lieu: props.post.lieu,
    status: props.post.status,
    image_video: null as File | null,
});

// Typage correct pour le ref de Modal
const modalRef = ref<{ close: () => void } | null>(null);

const submit = () => {
    form.put(`/posts/${props.post.id}`, {
        preserveScroll: true,
        onSuccess() {
            modalRef.value?.close();
        }
    });
};

// Fonction avec typage correct pour l'événement
const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.image_video = target.files?.[0] || null;
};
</script>

<template>
    <Modal ref="modalRef" #default="{ close }">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Modifier le post</h2>
                <p class="text-sm text-gray-500">
                    Modifiez les informations de votre post
                </p>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label for="title">Titre</Label>
                    <Input
                        id="title"
                        v-model="form.title"
                        :class="{ 'border-red-500': form.errors.title }"
                    />
                    <p v-if="form.errors.title" class="text-sm text-red-500">
                        {{ form.errors.title }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="content">Contenu</Label>
                    <Textarea
                        id="content"
                        v-model="form.content"
                        rows="5"
                        :class="{ 'border-red-500': form.errors.content }"
                    />
                    <p v-if="form.errors.content" class="text-sm text-red-500">
                        {{ form.errors.content }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="category">Catégorie</Label>
                        <Input
                            id="category"
                            v-model="form.category"
                            :class="{ 'border-red-500': form.errors.category }"
                        />
                        <p v-if="form.errors.category" class="text-sm text-red-500">
                            {{ form.errors.category }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <Label for="lieu">Lieu</Label>
                        <Input
                            id="lieu"
                            v-model="form.lieu"
                            :class="{ 'border-red-500': form.errors.lieu }"
                        />
                        <p v-if="form.errors.lieu" class="text-sm text-red-500">
                            {{ form.errors.lieu }}
                        </p>
                    </div>
                </div>

                <div class="space-y-2">
                    <Label for="status">Status</Label>
                    <Select v-model="form.status">
                        <SelectTrigger>
                            <SelectValue placeholder="Sélectionner un status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="draft">Brouillon</SelectItem>
                            <SelectItem value="published">Publié</SelectItem>
                        </SelectContent>
                    </Select>
                    <p v-if="form.errors.status" class="text-sm text-red-500">
                        {{ form.errors.status }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="image_video">Image/Vidéo</Label>
                    <Input
                        id="image_video"
                        type="file"
                        accept="image/*,video/*"
                        @change="handleFileChange"
                        :class="{ 'border-red-500': form.errors.image_video }"
                    />
                    <p v-if="form.errors.image_video" class="text-sm text-red-500">
                        {{ form.errors.image_video }}
                    </p>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t">
                    <Button
                        type="button"
                        variant="outline"
                        @click="close"
                        :disabled="form.processing"
                    >
                        Annuler
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                    </Button>
                </div>
            </form>
        </div>
    </Modal>
</template>