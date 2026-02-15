<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { Button } from '@/components/ui/button';
import { Plus, Edit, Trash2, Eye } from 'lucide-vue-next';
import { ModalLink } from '@inertiaui/modal-vue'; 
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';

interface Post {
    id: number;
    title: string;
    content: string;
    category: string;
    lieu: string;
    status: string;
    created_at: string;
}

const props = defineProps<{
    posts: Post[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'My Posts',
        href: '/posts',
    },
];

const deletePost = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce post ?')) {
        router.delete(`/posts/${id}`);
    }
};

const getStatusVariant = (status: string) => {
    return status === 'published' ? 'default' : 'secondary';
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head title="My Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">My Posts</h1>
                    <p class="text-muted-foreground">
                        Gérez tous vos articles ici
                    </p>
                </div>
                <Button as-child>
                    <Link href="/posts/create">
                        <Plus class="mr-2 h-4 w-4" />
                        Nouveau Post
                    </Link>
                </Button>
            </div>

            <!-- Table -->
            <div class="rounded-xl border border-sidebar-border/70 bg-white dark:border-sidebar-border">
                <Table v-if="posts.length > 0">
                    <TableHeader>
                        <TableRow>
                            <TableHead>Titre</TableHead>
                            <TableHead>Catégorie</TableHead>
                            <TableHead>Lieu</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableCell class="font-medium">
                                {{ post.title }}
                            </TableCell>
                            <TableCell>{{ post.category }}</TableCell>
                            <TableCell>{{ post.lieu }}</TableCell>
                            <TableCell>
                                <Badge :variant="getStatusVariant(post.status)">
                                    {{ post.status }}
                                </Badge>
                            </TableCell>
                            <TableCell>{{ formatDate(post.created_at) }}</TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="icon" as-child>
                                        <Link :href="`/posts/${post.id}`">
                                            <Eye class="h-4 w-4" />
                                        </Link>
                                    </Button>
                                    
                                    <ModalLink
                                        slideover
                                        :href="`/posts/${post.id}/edit`"
                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10"
                                    >
                                        <Edit class="h-4 w-4" />
                                    </ModalLink>
                                    
                                    <ModalLink
                                        variant="ghost"
                                        size="icon"
                                        @click="deletePost(post.id)"
                                    >
                                        <Trash2 class="h-4 w-4 text-red-500" />
                                    </ModalLink>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <!-- Empty State -->
                <div
                    v-else
                    class="flex min-h-[400px] flex-col items-center justify-center p-8 text-center"
                >
                    <div class="mb-4 rounded-full bg-muted p-4">
                        <Plus class="h-8 w-8 text-muted-foreground" />
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Aucun post</h3>
                    <p class="mb-4 text-sm text-muted-foreground">
                        Vous n'avez pas encore créé de post. Commencez dès maintenant !
                    </p>
                    <Button as-child>
                        <Link href="/posts/create">
                            <Plus class="mr-2 h-4 w-4" />
                            Créer mon premier post
                        </Link>
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>