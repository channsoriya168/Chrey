<template>

    <Head title="Dashboard" />
    <div>
        <div class="d-flex align-center mb-4">
            <h2 class="text-h5 font-weight-medium">ស្ថិតិ</h2>
            <v-spacer></v-spacer>
            <!-- <v-btn icon size="small">
                <v-icon>mdi-refresh</v-icon>
            </v-btn> -->
        </div>

        <v-row>
            <v-col cols="12" md="6" lg="3">
                <v-card class="pa-4" color="primary" dark>
                    <div class="d-flex align-center">
                        <v-icon size="40" class="mr-3">mdi-account-multiple</v-icon>
                        <div>
                            <div class="text-h4 font-weight-bold">150</div>
                            <div class="text-body-2">អ្នកប្រើប្រាស់សរុប</div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" md="6" lg="3">
                <v-card class="pa-4" color="success" dark>
                    <div class="d-flex align-center">
                        <v-icon size="40" class="mr-3">mdi-package-variant</v-icon>
                        <div>
                            <div class="text-h4 font-weight-bold">85</div>
                            <div class="text-body-2">ផលិតផលសរុប</div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" md="6" lg="3">
                <v-card class="pa-4" color="warning" dark>
                    <div class="d-flex align-center">
                        <v-icon size="40" class="mr-3">mdi-tag-multiple</v-icon>
                        <div>
                            <div class="text-h4 font-weight-bold">12</div>
                            <div class="text-body-2">ប្រភេទសរុប</div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" md="6" lg="3">
                <v-card class="pa-4" color="error" dark>
                    <div class="d-flex align-center">
                        <v-icon size="40" class="mr-3">mdi-cart</v-icon>
                        <div>
                            <div class="text-h4 font-weight-bold">45</div>
                            <div class="text-body-2">ការបញ្ជាទិញ</div>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script setup>

</script>