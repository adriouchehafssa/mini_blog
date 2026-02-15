<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
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
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'My Posts',
        href: '/posts',
    },
    {
        title: 'Créer un post',
        href: '/posts/create',
    },
];

const form = useForm({
    title: '',
    content: '',
    category: '',
    image_video: null as File | null,
    lieu: '',
    status: 'draft',
});

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image_video = target.files[0];
    }
};

const submit = () => {
    form.post('/posts', {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Créer un Post" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <a href="/posts">
                        <ArrowLeft class="h-4 w-4" />
                    </a>
                </Button>
                <div>
                    <h1 class="text-2xl font-bold">Créer un nouveau post</h1>
                    <p class="text-muted-foreground">
                        Remplissez le formulaire ci-dessous
                    </p>
                </div>
            </div>

            <!-- Form -->
            <Card>
                <CardHeader>
                    <CardTitle>Informations du post</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Title -->
                        <div class="space-y-2">
                            <Label for="title">Titre *</Label>
                            <Input
                                id="title"
                                v-model="form.title"
                                type="text"
                                placeholder="Entrez le titre du post"
                                :class="{ 'border-red-500': form.errors.title }"
                            />
                            <p v-if="form.errors.title" class="text-sm text-red-500">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <!-- Content -->
                        <div class="space-y-2">
                            <Label for="content">Contenu *</Label>
                            <Textarea
                                id="content"
                                v-model="form.content"
                                placeholder="Écrivez le contenu de votre post"
                                rows="6"
                                :class="{ 'border-red-500': form.errors.content }"
                            />
                            <p v-if="form.errors.content" class="text-sm text-red-500">
                                {{ form.errors.content }}
                            </p>
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <Label for="category">Catégorie *</Label>
                            <Input
                                id="category"
                                v-model="form.category"
                                type="text"
                                placeholder="Ex: Technologie, Voyage, etc."
                                :class="{ 'border-red-500': form.errors.category }"
                            />
                            <p v-if="form.errors.category" class="text-sm text-red-500">
                                {{ form.errors.category }}
                            </p>
                        </div>

                        <!-- Lieu -->
                        <div class="space-y-2">
                            <Label for="lieu">Lieu *</Label>
                            <Input
                                id="lieu"
                                v-model="form.lieu"
                                type="text"
                                placeholder="Ex: Paris, France"
                                :class="{ 'border-red-500': form.errors.lieu }"
                            />
                            <p v-if="form.errors.lieu" class="text-sm text-red-500">
                                {{ form.errors.lieu }}
                            </p>
                        </div>

                        <!-- Image/Video -->
                        <div class="space-y-2">
                            <Label for="image_video">Image ou Vidéo</Label>
                            <Input
                                id="image_video"
                                type="file"
                                accept="image/*,video/*"
                                @change="handleFileChange"
                                :class="{ 'border-red-500': form.errors.image_video }"
                            />
                            <p class="text-sm text-muted-foreground">
                                Formats acceptés: JPG, PNG, MP4, MOV (max 20MB)
                            </p>
                            <p v-if="form.errors.image_video" class="text-sm text-red-500">
                                {{ form.errors.image_video }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <Label for="status">Status *</Label>
                            <Select v-model="form.status">
                                <SelectTrigger
                                    :class="{ 'border-red-500': form.errors.status }"
                                >
                                    <SelectValue placeholder="Sélectionnez le status" />
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

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="min-w-[120px]"
                            >
                                {{ form.processing ? 'Création...' : 'Créer le post' }}
                            </Button>
                            <Button variant="outline" as-child>
                                <a href="/posts">Annuler</a>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>