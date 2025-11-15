import { cva } from 'class-variance-authority'

export { default as Alert } from './Alert.vue'
export { default as AlertDescription } from './AlertDescription.vue'
export { default as AlertTitle } from './AlertTitle.vue'

export const alertVariants = cva(
    'relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground',
    {
        variants: {
            variant: {
                default:
                    'bg-blue-500 dark:bg-blue-600 text-white dark:text-white border-blue-600 dark:border-blue-700 [&>svg]:text-white dark:[&>svg]:text-white',
                destructive:
                    'bg-red-500 dark:bg-red-600 text-white dark:text-white border-red-600 dark:border-red-700 [&>svg]:text-white dark:[&>svg]:text-white',
                success:
                    'bg-green-500 dark:bg-green-600 text-white dark:text-white border-green-600 dark:border-green-700 [&>svg]:text-white dark:[&>svg]:text-white',
                warning:
                    'bg-amber-500 dark:bg-amber-600 text-white dark:text-white border-amber-600 dark:border-amber-700 [&>svg]:text-white dark:[&>svg]:text-white'
            }
        },
        defaultVariants: {
            variant: 'default'
        }
    }
)
